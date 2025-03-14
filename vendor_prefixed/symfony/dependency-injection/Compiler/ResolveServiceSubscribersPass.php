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

use WPPluginSkeleton_Vendor\Psr\Container\ContainerInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Definition;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Reference;
use WPPluginSkeleton_Vendor\Symfony\Contracts\Service\ServiceProviderInterface;
/**
 * Compiler pass to inject their service locator to service subscribers.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 * @internal
 */
class ResolveServiceSubscribersPass extends AbstractRecursivePass
{
    protected bool $skipScalars = \true;
    private ?string $serviceLocator = null;
    protected function processValue(mixed $value, bool $isRoot = \false) : mixed
    {
        if ($value instanceof Reference && $this->serviceLocator && \in_array((string) $value, [ContainerInterface::class, ServiceProviderInterface::class], \true)) {
            return new Reference($this->serviceLocator);
        }
        if (!$value instanceof Definition) {
            return parent::processValue($value, $isRoot);
        }
        $serviceLocator = $this->serviceLocator;
        $this->serviceLocator = null;
        if ($value->hasTag('container.service_subscriber.locator')) {
            $this->serviceLocator = $value->getTag('container.service_subscriber.locator')[0]['id'];
            $value->clearTag('container.service_subscriber.locator');
        }
        try {
            return parent::processValue($value);
        } finally {
            $this->serviceLocator = $serviceLocator;
        }
    }
}
