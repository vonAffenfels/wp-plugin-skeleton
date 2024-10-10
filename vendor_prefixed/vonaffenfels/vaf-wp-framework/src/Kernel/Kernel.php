<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Kernel;

use Closure;
use Exception;
use ReflectionObject;
use RuntimeException;
use WPPluginSkeleton_Vendor\Symfony\Component\Config\Builder\ConfigBuilderGenerator;
use WPPluginSkeleton_Vendor\Symfony\Component\Config\ConfigCache;
use WPPluginSkeleton_Vendor\Symfony\Component\Config\FileLocator;
use WPPluginSkeleton_Vendor\Symfony\Component\Config\Loader\DelegatingLoader;
use WPPluginSkeleton_Vendor\Symfony\Component\Config\Loader\LoaderInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\Config\Loader\LoaderResolver;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Compiler\PassConfig;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Container;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Loader\ClosureLoader;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractConfigurator;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Loader\DirectoryLoader;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Loader\IniFileLoader;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Reference;
/**
 * The Kernel is the heart of the library system.
 * @internal
 */
abstract class Kernel
{
    private const CONTAINER_CLASS = 'CachedContainer';
    protected ?Container $container = null;
    protected bool $booted = \false;
    public function __construct(protected readonly string $projectDir, protected readonly bool $debug, protected readonly string $namespace)
    {
    }
    private function __clone()
    {
    }
    /**
     * @throws Exception
     */
    public function boot() : void
    {
        if (\true === $this->booted) {
            return;
        }
        $this->bootHandler();
        $this->booted = \true;
    }
    protected function bootHandler() : void
    {
    }
    public function isDebug() : bool
    {
        return $this->debug;
    }
    /**
     * Gets the application root dir (path of the project's composer file).
     */
    public function getProjectDir() : string
    {
        return $this->projectDir;
    }
    public function getBuildDir() : string
    {
        return $this->getProjectDir() . '/container/';
    }
    protected abstract function configureContainer(ContainerConfigurator $container, LoaderInterface $loader, ContainerBuilder $builder) : void;
    /**
     * @throws Exception
     */
    private function registerContainerConfiguration(LoaderInterface $loader) : void
    {
        $loader->load(function (ContainerBuilder $container) use($loader) {
            $kernelClass = \str_contains(static::class, "@anonymous\x00") ? self::class : static::class;
            if (!$container->hasDefinition('kernel')) {
                $container->register('kernel', $kernelClass)->setAutoconfigured(\true)->setSynthetic(\true)->setPublic(\true);
            }
            $container->addObjectResource($this);
            $file = (new ReflectionObject($this))->getFileName();
            /* @var ContainerPhpFileLoader $kernelLoader */
            $kernelLoader = $loader->getResolver()->resolve($file);
            $kernelLoader->setCurrentDir(\dirname($file));
            $instanceof = Closure::bind(function &() {
                return $this->instanceof;
            }, $kernelLoader, $kernelLoader)();
            $valuePreProcessor = AbstractConfigurator::$valuePreProcessor;
            AbstractConfigurator::$valuePreProcessor = function ($value) {
                return $this === $value ? new Reference('kernel') : $value;
            };
            try {
                $this->configureContainer(new ContainerConfigurator($container, $kernelLoader, $instanceof, $file, $file), $loader, $container);
            } finally {
                $instanceof = [];
                $kernelLoader->registerAliasesForSinglyImplementedInterfaces();
                AbstractConfigurator::$valuePreProcessor = $valuePreProcessor;
            }
            // Register all parent classes of kernel as aliases
            foreach (\class_parents($this) as $parent) {
                if (!$container->hasAlias($parent)) {
                    $container->setAlias($parent, 'kernel');
                }
            }
            $container->setAlias($kernelClass, 'kernel')->setPublic(\true);
        });
    }
    public function forceContainerCacheUpdate() : void
    {
        $container = $this->buildContainer();
        $container->compile();
        $this->updateContainerCache($container);
    }
    public function getContainer() : ContainerInterface
    {
        if (!\is_null($this->container)) {
            return $this->container;
        }
        $cache = new ConfigCache($this->getBuildDir() . '/' . self::CONTAINER_CLASS . '.php', $this->isDebug());
        if ($cache->isFresh() && \is_readable($cache->getPath())) {
            // Load cached container if cache is still good
            // If not in debug mode and cache file exists cache will always be good
            // Load cached container if exists
            require_once $cache->getPath();
            $class = $this->namespace . "\\" . self::CONTAINER_CLASS;
            $container = new $class();
        } else {
            // Cache is not good so we compile the container
            $container = $this->buildContainer();
            $container->compile();
            // Try to cache the container if possible
            try {
                $this->updateContainerCache($container, $cache);
            } catch (RuntimeException $e) {
                // Do nothing if directories can't be created
                // We simply can't cache the container then
            }
        }
        if (!\is_null($container)) {
            $this->container = $container;
            $this->container->set('kernel', $this);
        }
        return $this->container;
    }
    public function updateContainerCache(ContainerBuilder $container, ?ConfigCache $cache = null) : void
    {
        $cache ??= new ConfigCache($this->getBuildDir() . '/' . self::CONTAINER_CLASS . '.php', $this->isDebug());
        $this->checkBuildDirectories();
        $dumper = new PhpDumper($container);
        $code = $dumper->dump(['class' => self::CONTAINER_CLASS, 'namespace' => $this->namespace]);
        $cache->write($code, $container->getResources());
    }
    private function checkBuildDirectories() : void
    {
        $dirs = ['build' => $this->getBuildDir()];
        foreach ($dirs as $name => $dir) {
            if (!\is_dir($dir)) {
                if (\false === @\mkdir($dir, 0777, \true) && !\is_dir($dir)) {
                    throw new RuntimeException(\sprintf('Unable to create the "%s" directory (%s).', $name, $dir));
                }
            } elseif (!\is_writable($dir)) {
                throw new RuntimeException(\sprintf('Unable to write in the "%s" directory (%s).', $name, $dir));
            }
        }
    }
    /**
     * Returns the kernel parameters.
     */
    private function getKernelParameters() : array
    {
        return ['kernel.debug' => $this->debug, 'kernel.container_class' => self::CONTAINER_CLASS];
    }
    /**
     * Builds the service container.
     * @throws Exception
     */
    private function buildContainer() : ContainerBuilder
    {
        $container = $this->getContainerBuilder();
        $container->addObjectResource($this);
        $this->registerContainerConfiguration($this->getContainerLoader($container));
        return $container;
    }
    /**
     * Gets a new ContainerBuilder instance used to build the service container.
     */
    private function getContainerBuilder() : ContainerBuilder
    {
        $container = new ContainerBuilder();
        $container->getParameterBag()->add($this->getKernelParameters());
        if ($this instanceof CompilerPassInterface) {
            $container->addCompilerPass($this, PassConfig::TYPE_BEFORE_OPTIMIZATION, -10000);
        }
        return $container;
    }
    /**
     * Returns a loader for the container.
     */
    private function getContainerLoader(ContainerBuilder $container) : DelegatingLoader
    {
        $locator = new FileLocator();
        $resolver = new LoaderResolver([new XmlFileLoader($container, $locator), new YamlFileLoader($container, $locator), new IniFileLoader($container, $locator), new PhpFileLoader($container, $locator, null, \class_exists(ConfigBuilderGenerator::class) ? new ConfigBuilderGenerator($this->getBuildDir()) : null), new GlobFileLoader($container, $locator), new DirectoryLoader($container, $locator), new ClosureLoader($container)]);
        return new DelegatingLoader($resolver);
    }
}
