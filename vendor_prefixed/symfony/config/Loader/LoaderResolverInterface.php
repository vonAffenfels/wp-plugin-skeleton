<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WPPluginSkeleton_Vendor\Symfony\Component\Config\Loader;

/**
 * LoaderResolverInterface selects a loader for a given resource.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @internal
 */
interface LoaderResolverInterface
{
    /**
     * Returns a loader able to load the resource.
     *
     * @param string|null $type The resource type or null if unknown
     */
    public function resolve(mixed $resource, ?string $type = null) : LoaderInterface|false;
}
