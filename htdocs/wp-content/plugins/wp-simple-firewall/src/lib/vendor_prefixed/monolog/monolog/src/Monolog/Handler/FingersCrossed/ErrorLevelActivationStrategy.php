<?php
/**
 * @license MIT
 *
 * Modified by Paul Goodchild on 25-November-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */ declare(strict_types=1);

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AptowebDeps\Monolog\Handler\FingersCrossed;

use AptowebDeps\Monolog\Logger;
use Psr\Log\LogLevel;

/**
 * Error level based activation strategy.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * @phpstan-import-type Level from \Monolog\Logger
 * @phpstan-import-type LevelName from \Monolog\Logger
 */
class ErrorLevelActivationStrategy implements ActivationStrategyInterface
{
    /**
     * @var Level
     */
    private $actionLevel;

    /**
     * @param int|string $actionLevel Level or name or value
     *
     * @phpstan-param Level|LevelName|LogLevel::* $actionLevel
     */
    public function __construct($actionLevel)
    {
        $this->actionLevel = Logger::toMonologLevel($actionLevel);
    }

    public function isHandlerActivated(array $record): bool
    {
        return $record['level'] >= $this->actionLevel;
    }
}
