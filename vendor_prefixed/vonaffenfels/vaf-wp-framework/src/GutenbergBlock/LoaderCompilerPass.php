<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\GutenbergBlock;

use LogicException;
use ReflectionClass;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\GutenbergBlock\Attribute\AsDynamicBlock;
/** @internal */
final class LoaderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container) : void
    {
        if (!$container->has('gutenbergblock.loader')) {
            return;
        }
        $loaderDefinition = $container->findDefinition('gutenbergblock.loader');
        $dynamicBlockServicess = $container->findTaggedServiceIds('gutenbergblock.dynamicblock');
        $dynamicBlockDefinitions = [];
        foreach ($dynamicBlockServicess as $id => $tags) {
            $definition = $container->findDefinition($id);
            $definition->setPublic(\true);
            $dynamicBlockDefinitions[$id] = $this->getDynamicBlockDefinition($definition->getClass(), $container);
        }
        $loaderDefinition->setArgument('$dynamicBlocks', $dynamicBlockDefinitions);
    }
    private function getDynamicBlockDefinition(string $class, ContainerBuilder $container) : array
    {
        $reflection = new ReflectionClass($class);
        if (!$reflection->hasMethod('render')) {
            throw new NoRenderMethodException($class);
        }
        if (empty($reflection->getAttributes(AsDynamicBlock::class))) {
            throw new LogicException("DynamicBlock without AsDynamicBlock Attribute - should be impossible");
        }
        $attribute = $reflection->getAttributes(AsDynamicBlock::class)[0]->newInstance();
        return ['type' => $attribute->blockType, 'class' => $class, 'renderer' => RendererDefinition::fromClassReflection($reflection)->definition(), 'options' => ['api_version' => $attribute->version, 'editor_script' => $attribute->editorScriptHandle, 'attributes' => $attribute->attributes]];
    }
}
