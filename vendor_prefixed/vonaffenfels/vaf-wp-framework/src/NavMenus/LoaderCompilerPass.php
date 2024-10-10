<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\NavMenus;

use Exception;
use ReflectionClass;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Definition;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\NavMenus\Attributes\NavMenu;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils\ClassSystem;
/** @internal */
class LoaderCompilerPass implements CompilerPassInterface
{
    /**
     * @throws Exception
     */
    public function process(ContainerBuilder $container) : void
    {
        if (!$container->has(Loader::class)) {
            return;
        }
        $loaderDefinition = $container->findDefinition(Loader::class);
        $navMenuServices = $container->findTaggedServiceIds('navmenus.menu');
        $menuData = [];
        foreach ($navMenuServices as $id => $tags) {
            $definition = $container->findDefinition($id);
            $menuData = \array_merge($menuData, $this->getMenuData($definition, $container));
        }
        $loaderDefinition->setArgument('$navMenus', $menuData);
    }
    /**
     * @throws Exception
     */
    private function getMenuData(Definition $definition, ContainerBuilder $container) : array
    {
        $reflection = new ReflectionClass($definition->getClass());
        $attribute = $reflection->getAttributes(NavMenu::class);
        if (empty($attribute)) {
            return [];
        }
        if (!ClassSystem::isExtendsOrImplements(AbstractNavMenu::class, $reflection->getName())) {
            throw new Exception(\sprintf('NavMenu %s needs to extend %s!', $reflection->getName(), AbstractNavMenu::class));
        }
        /** @var NavMenu $instance */
        $instance = $attribute[0]->newInstance();
        $definition->setArgument('$slug', $instance->slug);
        return [$instance->slug => $instance->description];
    }
}
