<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WPPluginSkeleton_Vendor\Symfony\Component\Config\Definition;

use WPPluginSkeleton_Vendor\Symfony\Component\Config\Definition\Builder\TreeBuilder;
use WPPluginSkeleton_Vendor\Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use WPPluginSkeleton_Vendor\Symfony\Component\Config\Definition\Loader\DefinitionFileLoader;
use WPPluginSkeleton_Vendor\Symfony\Component\Config\FileLocator;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 *
 * @final
 * @internal
 */
class Configuration implements ConfigurationInterface
{
    public function __construct(private ConfigurableInterface $subject, private ?ContainerBuilder $container, private string $alias)
    {
    }
    public function getConfigTreeBuilder() : TreeBuilder
    {
        $treeBuilder = new TreeBuilder($this->alias);
        $file = (new \ReflectionObject($this->subject))->getFileName();
        $loader = new DefinitionFileLoader($treeBuilder, new FileLocator(\dirname($file)), $this->container);
        $configurator = new DefinitionConfigurator($treeBuilder, $loader, $file, $file);
        $this->subject->configure($configurator);
        return $treeBuilder;
    }
}
