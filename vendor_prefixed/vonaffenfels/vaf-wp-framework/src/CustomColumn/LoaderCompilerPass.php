<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\CustomColumn;

use ReflectionClass;
use ReflectionMethod;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\CustomColumn\Attribute\CustomColumn;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Slug;
/** @internal */
final class LoaderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container) : void
    {
        if (!$container->has('customColumn.loader')) {
            return;
        }
        $loaderDefinition = $container->findDefinition('customColumn.loader');
        $customColumnContainerServices = $container->findTaggedServiceIds('customColumn.container');
        $customColumnContainerData = [];
        foreach ($customColumnContainerServices as $id => $tags) {
            $definition = $container->findDefinition($id);
            $definition->setPublic(\true);
            $customColumnContainerData[$id] = $this->getCustomColumnContainerData($definition->getClass(), $container);
        }
        $loaderDefinition->setArgument('$customColumnContainer', $customColumnContainerData);
    }
    private function getCustomColumnContainerData(string $class, ContainerBuilder $container) : array
    {
        $data = [];
        $reflection = new ReflectionClass($class);
        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $methodName = $method->getName();
            // Check if the CustomColumn attribute is present
            $attributes = $method->getAttributes(CustomColumn::class);
            if (empty($attributes)) {
                continue;
            }
            foreach ($attributes as $attribute) {
                /**
                 * @var CustomColumn $instance
                 */
                $instance = $attribute->newInstance();
                $data[] = ['method' => $methodName, 'name' => Slug::fromName($instance->title) . '-custom', 'title' => $instance->title, 'postTypes' => $instance->postTypes, 'supporting' => $instance->supporting];
            }
        }
        return $data;
    }
}
