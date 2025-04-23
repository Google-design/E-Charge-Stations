<?php
/**
 * @license MIT
 *
 * Modified by Paul Goodchild on 25-November-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

declare(strict_types=1);

namespace AptowebDeps\CrowdSec\Common\Logger;

use AptowebDeps\Monolog\Logger;

/**
 * Abstract class for Monolog logger implementation.
 *
 * @author    CrowdSec team
 *
 * @see      https://crowdsec.net CrowdSec Official Website
 *
 * @copyright Copyright (c) 2022+ CrowdSec
 * @license   MIT License
 */
abstract class AbstractLog extends Logger
{
    /**
     * @var string Format of log messages
     */
    protected $format = "%datetime%|%level%|%message%|%context%\n";

    public function __construct(array $configs, string $name)
    {
        $this->format = $configs['format'] ?? $this->format;
        parent::__construct($name);
    }
}
