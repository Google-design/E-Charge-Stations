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

namespace AptowebDeps\Symfony\Component\Uid\Factory;

use AptowebDeps\Symfony\Component\Uid\Uuid;
use AptowebDeps\Symfony\Component\Uid\UuidV1;
use AptowebDeps\Symfony\Component\Uid\UuidV6;

class TimeBasedUuidFactory
{
    private $class;
    private $node;

    public function __construct(string $class, ?Uuid $node = null)
    {
        $this->class = $class;
        $this->node = $node;
    }

    /**
     * @return UuidV6|UuidV1
     */
    public function create(?\DateTimeInterface $time = null): Uuid
    {
        $class = $this->class;

        if (null === $time && null === $this->node) {
            return new $class();
        }

        return new $class($class::generate($time, $this->node));
    }
}
