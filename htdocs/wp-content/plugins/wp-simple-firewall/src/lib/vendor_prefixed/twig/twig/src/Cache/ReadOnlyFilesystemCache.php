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

namespace AptowebDeps\Twig\Cache;

/**
 * Implements a cache on the filesystem that can only be read, not written to.
 *
 * @author Quentin Devos <quentin@devos.pm>
 */
class ReadOnlyFilesystemCache extends FilesystemCache
{
    public function write(string $key, string $content): void
    {
        // Do nothing with the content, it's a read-only filesystem.
    }
}
