<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Setting;

use ReflectionClass;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Setting\Attribute\AsSettingContainer;
/** @internal */
final class CompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container) : void
    {
        $settingContainerServices = $container->findTaggedServiceIds('setting.container');
        foreach ($settingContainerServices as $id => $tags) {
            $definition = $container->findDefinition($id);
            $reflection = new ReflectionClass($definition->getClass());
            $attributes = $reflection->getAttributes(AsSettingContainer::class);
            if (empty($attributes)) {
                continue;
            }
            /** @var AsSettingContainer $attrInstance */
            $attrInstance = $attributes[0]->newInstance();
            $definition->setArgument('$name', $attrInstance->name);
            $definition->setArgument('$default', $attrInstance->default);
        }
    }
}
