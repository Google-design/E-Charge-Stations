<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Modified by Paul Goodchild on 25-November-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace AptowebDeps\Symfony\Component\Config\Definition\Builder;

use AptowebDeps\Symfony\Component\Config\Definition\EnumNode;

/**
 * Enum Node Definition.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class EnumNodeDefinition extends ScalarNodeDefinition
{
    private $values;

    /**
     * @return $this
     */
    public function values(array $values)
    {
        $values = array_unique($values);

        if (empty($values)) {
            throw new \InvalidArgumentException('->values() must be called with at least one value.');
        }

        $this->values = $values;

        return $this;
    }

    /**
     * Instantiate a Node.
     *
     * @return EnumNode
     *
     * @throws \RuntimeException
     */
    protected function instantiateNode()
    {
        if (null === $this->values) {
            throw new \RuntimeException('You must call ->values() on enum nodes.');
        }

        return new EnumNode($this->name, $this->parent, $this->values, $this->pathSeparator);
    }
}
