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

namespace AptowebDeps\Symfony\Component\Config;

use AptowebDeps\Symfony\Component\Config\Resource\ResourceInterface;

/**
 * Interface for ConfigCache.
 *
 * @author Matthias Pigulla <mp@webfactory.de>
 */
interface ConfigCacheInterface
{
    /**
     * Gets the cache file path.
     *
     * @return string
     */
    public function getPath();

    /**
     * Checks if the cache is still fresh.
     *
     * This check should take the metadata passed to the write() method into consideration.
     *
     * @return bool
     */
    public function isFresh();

    /**
     * Writes the given content into the cache file. Metadata will be stored
     * independently and can be used to check cache freshness at a later time.
     *
     * @param string                   $content  The content to write into the cache
     * @param ResourceInterface[]|null $metadata An array of ResourceInterface instances
     *
     * @throws \RuntimeException When the cache file cannot be written
     */
    public function write(string $content, ?array $metadata = null);
}
