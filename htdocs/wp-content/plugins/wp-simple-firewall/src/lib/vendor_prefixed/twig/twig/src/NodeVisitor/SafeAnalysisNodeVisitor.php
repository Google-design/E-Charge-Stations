<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Modified by Paul Goodchild on 25-November-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace AptowebDeps\Twig\NodeVisitor;

use AptowebDeps\Twig\Environment;
use AptowebDeps\Twig\Node\Expression\BlockReferenceExpression;
use AptowebDeps\Twig\Node\Expression\ConditionalExpression;
use AptowebDeps\Twig\Node\Expression\ConstantExpression;
use AptowebDeps\Twig\Node\Expression\FilterExpression;
use AptowebDeps\Twig\Node\Expression\FunctionExpression;
use AptowebDeps\Twig\Node\Expression\GetAttrExpression;
use AptowebDeps\Twig\Node\Expression\MethodCallExpression;
use AptowebDeps\Twig\Node\Expression\NameExpression;
use AptowebDeps\Twig\Node\Expression\ParentExpression;
use AptowebDeps\Twig\Node\Node;

/**
 * @internal
 */
final class SafeAnalysisNodeVisitor implements NodeVisitorInterface
{
    private $data = [];
    private $safeVars = [];

    public function setSafeVars(array $safeVars): void
    {
        $this->safeVars = $safeVars;
    }

    public function getSafe(Node $node)
    {
        $hash = spl_object_hash($node);
        if (!isset($this->data[$hash])) {
            return;
        }

        foreach ($this->data[$hash] as $bucket) {
            if ($bucket['key'] !== $node) {
                continue;
            }

            if (\in_array('html_attr', $bucket['value'])) {
                $bucket['value'][] = 'html';
            }

            return $bucket['value'];
        }
    }

    private function setSafe(Node $node, array $safe): void
    {
        $hash = spl_object_hash($node);
        if (isset($this->data[$hash])) {
            foreach ($this->data[$hash] as &$bucket) {
                if ($bucket['key'] === $node) {
                    $bucket['value'] = $safe;

                    return;
                }
            }
        }
        $this->data[$hash][] = [
            'key' => $node,
            'value' => $safe,
        ];
    }

    public function enterNode(Node $node, Environment $env): Node
    {
        return $node;
    }

    public function leaveNode(Node $node, Environment $env): ?Node
    {
        if ($node instanceof ConstantExpression) {
            // constants are marked safe for all
            $this->setSafe($node, ['all']);
        } elseif ($node instanceof BlockReferenceExpression) {
            // blocks are safe by definition
            $this->setSafe($node, ['all']);
        } elseif ($node instanceof ParentExpression) {
            // parent block is safe by definition
            $this->setSafe($node, ['all']);
        } elseif ($node instanceof ConditionalExpression) {
            // intersect safeness of both operands
            $safe = $this->intersectSafe($this->getSafe($node->getNode('expr2')), $this->getSafe($node->getNode('expr3')));
            $this->setSafe($node, $safe);
        } elseif ($node instanceof FilterExpression) {
            // filter expression is safe when the filter is safe
            $name = $node->getNode('filter')->getAttribute('value');
            $args = $node->getNode('arguments');
            if ($filter = $env->getFilter($name)) {
                $safe = $filter->getSafe($args);
                if (null === $safe) {
                    $safe = $this->intersectSafe($this->getSafe($node->getNode('node')), $filter->getPreservesSafety());
                }
                $this->setSafe($node, $safe);
            } else {
                $this->setSafe($node, []);
            }
        } elseif ($node instanceof FunctionExpression) {
            // function expression is safe when the function is safe
            $name = $node->getAttribute('name');
            $args = $node->getNode('arguments');
            if ($function = $env->getFunction($name)) {
                $this->setSafe($node, $function->getSafe($args));
            } else {
                $this->setSafe($node, []);
            }
        } elseif ($node instanceof MethodCallExpression) {
            if ($node->getAttribute('safe')) {
                $this->setSafe($node, ['all']);
            } else {
                $this->setSafe($node, []);
            }
        } elseif ($node instanceof GetAttrExpression && $node->getNode('node') instanceof NameExpression) {
            $name = $node->getNode('node')->getAttribute('name');
            if (\in_array($name, $this->safeVars)) {
                $this->setSafe($node, ['all']);
            } else {
                $this->setSafe($node, []);
            }
        } else {
            $this->setSafe($node, []);
        }

        return $node;
    }

    private function intersectSafe(?array $a = null, ?array $b = null): array
    {
        if (null === $a || null === $b) {
            return [];
        }

        if (\in_array('all', $a)) {
            return $b;
        }

        if (\in_array('all', $b)) {
            return $a;
        }

        return array_intersect($a, $b);
    }

    public function getPriority(): int
    {
        return 0;
    }
}
