<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection;

/**
 * EnvVarLoaderInterface objects return key/value pairs that are added to the list of available env vars.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 * @internal
 */
interface EnvVarLoaderInterface
{
    /**
     * @return array<string|\Stringable> Key/value pairs that can be accessed using the regular "%env()%" syntax
     */
    public function loadEnvVars() : array;
}
