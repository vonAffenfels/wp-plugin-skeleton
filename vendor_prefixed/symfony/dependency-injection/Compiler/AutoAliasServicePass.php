<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Compiler;

use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Alias;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
/**
 * Sets a service to be an alias of another one, given a format pattern.
 * @internal
 */
class AutoAliasServicePass implements CompilerPassInterface
{
    /**
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('auto_alias') as $serviceId => $tags) {
            foreach ($tags as $tag) {
                if (!isset($tag['format'])) {
                    throw new InvalidArgumentException(\sprintf('Missing tag information "format" on auto_alias service "%s".', $serviceId));
                }
                $aliasId = $container->getParameterBag()->resolveValue($tag['format']);
                if ($container->hasDefinition($aliasId) || $container->hasAlias($aliasId)) {
                    $alias = new Alias($aliasId, $container->getDefinition($serviceId)->isPublic());
                    $container->setAlias($serviceId, $alias);
                }
            }
        }
    }
}
