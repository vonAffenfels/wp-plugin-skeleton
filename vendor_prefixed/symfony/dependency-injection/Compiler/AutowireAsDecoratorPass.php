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

use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Definition;
/**
 * Reads #[AsDecorator] attributes on definitions that are autowired
 * and don't have the "container.ignore_attributes" tag.
 * @internal
 */
final class AutowireAsDecoratorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container) : void
    {
        foreach ($container->getDefinitions() as $definition) {
            if ($this->accept($definition) && ($reflectionClass = $container->getReflectionClass($definition->getClass(), \false))) {
                $this->processClass($definition, $reflectionClass);
            }
        }
    }
    private function accept(Definition $definition) : bool
    {
        return !$definition->hasTag('container.ignore_attributes') && $definition->isAutowired();
    }
    private function processClass(Definition $definition, \ReflectionClass $reflectionClass) : void
    {
        foreach ($reflectionClass->getAttributes(AsDecorator::class, \ReflectionAttribute::IS_INSTANCEOF) as $attribute) {
            $attribute = $attribute->newInstance();
            $definition->setDecoratedService($attribute->decorates, null, $attribute->priority, $attribute->onInvalid);
        }
    }
}
