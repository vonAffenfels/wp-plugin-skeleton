<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WPPluginSkeleton_Vendor\Symfony\Component\Console\CommandLoader;

use WPPluginSkeleton_Vendor\Symfony\Component\Console\Command\Command;
use WPPluginSkeleton_Vendor\Symfony\Component\Console\Exception\CommandNotFoundException;
/**
 * @author Robin Chalas <robin.chalas@gmail.com>
 * @internal
 */
interface CommandLoaderInterface
{
    /**
     * Loads a command.
     *
     * @throws CommandNotFoundException
     */
    public function get(string $name) : Command;
    /**
     * Checks if a command exists.
     */
    public function has(string $name) : bool;
    /**
     * @return string[]
     */
    public function getNames() : array;
}
