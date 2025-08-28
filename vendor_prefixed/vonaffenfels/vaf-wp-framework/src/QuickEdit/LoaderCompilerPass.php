<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\QuickEdit;

use ReflectionClass;
use ReflectionMethod;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\QuickEdit\Attribute\QuickEdit;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Slug;
/** @internal */
final class LoaderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container) : void
    {
        if (!$container->has('quickedit.loader')) {
            return;
        }
        $loaderDefinition = $container->findDefinition('quickedit.loader');
        $quickeditContainerServices = $container->findTaggedServiceIds('quickedit.container');
        $quickeditContainerData = [];
        foreach ($quickeditContainerServices as $id => $tags) {
            $definition = $container->findDefinition($id);
            $definition->setPublic(\true);
            $quickeditContainerData[$id] = $this->getQuickEditContainerData($definition->getClass(), $container);
        }
        $loaderDefinition->setArgument('$quickeditContainer', $quickeditContainerData);
    }
    private function getQuickEditContainerData(string $class, ContainerBuilder $container) : array
    {
        $data = [];
        $reflection = new ReflectionClass($class);
        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $methodName = $method->getName();
            // Check if the QuickEdit attribute is present
            $attributes = $method->getAttributes(QuickEdit::class);
            if (empty($attributes)) {
                continue;
            }
            foreach ($attributes as $attribute) {
                /**
                 * @var QuickEdit $instance
                 */
                $instance = $attribute->newInstance();
                $data[] = ['method' => $methodName, 'name' => Slug::fromName($instance->title) . '-quick', 'title' => $instance->title, 'postTypes' => $instance->postTypes, 'supporting' => $instance->supporting];
            }
        }
        return $data;
    }
}
