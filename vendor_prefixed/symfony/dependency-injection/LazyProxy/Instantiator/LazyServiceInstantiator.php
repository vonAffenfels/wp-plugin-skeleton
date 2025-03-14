<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\LazyProxy\Instantiator;

use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Definition;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\LazyProxy\PhpDumper\LazyServiceDumper;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 * @internal
 */
final class LazyServiceInstantiator implements InstantiatorInterface
{
    public function instantiateProxy(ContainerInterface $container, Definition $definition, string $id, callable $realInstantiator) : object
    {
        $dumper = new LazyServiceDumper();
        if (!$dumper->isProxyCandidate($definition, $asGhostObject, $id)) {
            throw new InvalidArgumentException(\sprintf('Cannot instantiate lazy proxy for service "%s".', $id));
        }
        if (!\class_exists($proxyClass = $dumper->getProxyClass($definition, $asGhostObject), \false)) {
            eval($dumper->getProxyCode($definition, $id));
        }
        return $asGhostObject ? $proxyClass::createLazyGhost($realInstantiator) : $proxyClass::createLazyProxy($realInstantiator);
    }
}
