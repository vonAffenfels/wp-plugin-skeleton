<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework;

use Exception;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Kernel\Kernel;
/** @internal */
abstract class BaseWordpress
{
    protected Kernel $kernel;
    /**
     * @throws Exception
     */
    protected function __construct(private readonly string $name, private readonly string $path, private readonly string $url, private readonly bool $debug = \false)
    {
        $this->kernel = $this->createKernel();
    }
    public function configureContainer(ContainerBuilder $builder, ContainerConfigurator $configurator) : void
    {
    }
    protected abstract function createKernel() : Kernel;
    public final function getDebug() : bool
    {
        return $this->debug;
    }
    public function getPath() : string
    {
        return $this->path;
    }
    public final function getName() : string
    {
        return $this->name;
    }
    public final function getUrl() : string
    {
        return $this->url;
    }
    public final function getContainer() : ContainerInterface
    {
        return $this->kernel->getContainer();
    }
    public function getAssetUrl(string $asset) : string
    {
        return $this->url . 'public/' . $asset;
    }
}
