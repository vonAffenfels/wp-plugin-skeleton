<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Kernel;

use ReflectionClass;
use WPPluginSkeleton_Vendor\Symfony\Component\Config\Loader\LoaderInterface;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ChildDefinition;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\AdminAjax\Attributes\AsAdminAjaxContainer;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\AdminAjax\Loader as AdminAjaxLoader;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\AdminAjax\LoaderCompilerPass as AdminAjaxLoaderCompilerPass;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\AdminPages\Attributes\IsTabbedPage;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\AdminPages\TabbedPageCompilerPass;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\BaseWordpress;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\BulkEdit\Attribute\AsBulkEditContainer;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\GutenbergBlock\Attribute\AsDynamicBlock;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\GutenbergBlock\Loader as GutenbergBlockLoader;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\GutenbergBlock\LoaderCompilerPass as GutenbergBlockCompilerPass;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Hook\Attribute\AsHookContainer;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Hook\Loader as HookLoader;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Hook\LoaderCompilerPass as HookLoaderCompilerPass;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Menu\Attribute\AsMenuContainer;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Menu\Loader as MenuLoader;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Menu\LoaderCompilerPass as MenuLoaderCompilerPass;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Metabox\Attribute\AsMetaboxContainer;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Metabox\Loader as MetaboxLoader;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Metabox\LoaderCompilerPass as MetaboxLoaderCompilerPass;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\BulkEdit\Loader as BulkeditLoader;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\BulkEdit\LoaderCompilerPass as BulkeditLoaderCompilerPass;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\Attributes\PostType;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\Attributes\PostTypeExtension;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\ExtensionLoader as PostObjectExtensionLoader;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\ExtensionLoaderCompilerPass as PostObjectExtensionLoaderCompilerPass;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\PostObjectManager;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\PostTypeLoader;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\PostTypes\NavMenuItem;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\PostTypes\Page;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\PostTypes\Post;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Request;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\RestAPI\Attribute\AsRestContainer;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\RestAPI\Loader as RestAPILoader;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\RestAPI\LoaderCompilerPass as RestAPILoaderCompilerPass;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Setting\Attribute\AsSettingContainer;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Setting\CompilerPass as SettingCompilerpass;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Shortcode\Attribute\AsShortcodeContainer;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Shortcode\Loader as ShortcodeLoader;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Shortcode\LoaderCompilerPass as ShortcodeLoaderCompilerPass;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Template\Attribute\IsTemplate;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Template\Attribute\UseAdminAjax;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Template\Attribute\UseScript;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Attribute\AsFunctionContainer;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Attribute\AsTemplateEngine;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Engine\PHTMLEngine;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Engine\TwigRenderer\Extension;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Engine\TwigRenderer\FileLoader;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Engine\TwigEngine;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\EngineCompilerPass;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\FunctionCompilerPass;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\FunctionHandler;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Functions\BuiltIn\Wordpress;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\GlobalContext;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\NamespaceHandler;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\TemplateRenderer;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils\Templates\Admin\Notice;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils\Templates\Admin\ReactTemplate;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils\Templates\Admin\TabbedPage as TabbedPageTemplate;
/** @internal */
abstract class WordpressKernel extends Kernel
{
    public function __construct(string $projectDir, bool $debug, string $namespace, protected readonly BaseWordpress $base)
    {
        parent::__construct($projectDir, $debug, $namespace);
    }
    protected function bootHandler() : void
    {
        /** @var HookLoader $hookLoader */
        $hookLoader = $this->getContainer()->get('hook.loader');
        $hookLoader->registerHooks();
        /** @var MetaboxLoader $metaboxLoader */
        $metaboxLoader = $this->getContainer()->get('metabox.loader');
        $metaboxLoader->registerMetaboxes();
        /** @var BulkEditLoader $bulkeditLoader */
        $bulkeditLoader = $this->getContainer()->get('bulkedit.loader');
        $bulkeditLoader->registerBulkEditFields();
        /** @var GutenbergBlockLoader $gutenbergBlockLoader */
        $gutenbergBlockLoader = $this->getContainer()->get('gutenbergblock.loader');
        $gutenbergBlockLoader->registerBlocks();
        /** @var ShortcodeLoader $shortcodeLoader */
        $shortcodeLoader = $this->getContainer()->get('shortcode.loader');
        $shortcodeLoader->registerShortcodes();
        /** @var AdminAjaxLoader $adminAjaxLoader */
        $adminAjaxLoader = $this->getContainer()->get('adminajax.loader');
        $adminAjaxLoader->registerAdminAjaxActions();
        /** @var PostObjectExtensionLoader $extensionLoader */
        $extensionLoader = $this->getContainer()->get('postobject.extensionLoader');
        $extensionLoader->registerPostObjectExtensions();
        /** @var PostTypeLoader $postTypeLoader */
        $postTypeLoader = $this->getContainer()->get(PostTypeLoader::class);
        $postTypeLoader->registerPostTypes();
        // Registering REST routes
        add_action('rest_api_init', function () {
            /** @var RestAPILoader $restApiLoader */
            $restApiLoader = $this->getContainer()->get('restapi.loader');
            $restApiLoader->registerRestRoutes();
        });
        add_action('admin_menu', function () {
            /** @var MenuLoader $menuLoader */
            $menuLoader = $this->getContainer()->get('menu.loader');
            $menuLoader->registerMenus();
        });
    }
    /**
     * Configures the container.
     *
     * You can register services:
     *
     *     $container->services()->set('halloween', 'FooBundle\HalloweenProvider');
     *
     * Or parameters:
     *
     *     $container->parameters()->set('halloween', 'lot of fun');
     */
    protected function configureContainer(ContainerConfigurator $container, LoaderInterface $loader, ContainerBuilder $builder) : void
    {
        $configDir = $this->getConfigDir();
        if (\is_file($configDir . '/services.yaml')) {
            $container->import($configDir . '/services.yaml');
        } elseif (\is_file($configDir . '/services.php')) {
            $container->import($configDir . '/services.php');
        }
        $this->registerRequestService($builder);
        $this->registerTemplateRenderer($builder);
        $this->registerTemplate($builder);
        $this->registerHookContainer($builder);
        $this->registerMetaboxContainer($builder);
        $this->registerBulkeditContainer($builder);
        $this->registerGutenbergBlock($builder);
        $this->registerShortcodeContainer($builder);
        $this->registerSettingsContainer($builder);
        $this->registerRestAPIContainer($builder);
        $this->registerMenuContainer($builder);
        $this->registerAdminPages($builder);
        $this->registerAdminAjaxContainer($builder);
        $this->registerPostObjects($builder);
        $builder->register(ReactTemplate::class, ReactTemplate::class)->setAutoconfigured(\true)->setAutowired(\true);
        $this->base->configureContainer($builder, $container);
    }
    /**
     * Gets the path to the configuration directory.
     */
    private function getConfigDir() : string
    {
        return $this->getProjectDir() . '/config';
    }
    private function registerRequestService(ContainerBuilder $builder) : void
    {
        $builder->register(Request::class, Request::class)->setPublic(\true)->setAutowired(\true);
    }
    private function registerPostObjects(ContainerBuilder $builder) : void
    {
        $builder->register('postobject.extensionLoader', PostObjectExtensionLoader::class)->setPublic(\true)->setAutowired(\true);
        $builder->addCompilerPass(new PostObjectExtensionLoaderCompilerPass());
        $builder->registerAttributeForAutoconfiguration(PostTypeExtension::class, static function (ChildDefinition $definition) : void {
            $definition->addTag('postobject.extension');
        });
        $loaderDefinition = $builder->register(PostTypeLoader::class, PostTypeLoader::class)->setArgument('$postTypes', [])->setPublic(\true)->setAutowired(\true);
        $builder->registerAttributeForAutoconfiguration(PostType::class, static function (ChildDefinition $definition, PostType $attribute, ReflectionClass $reflectionClass) use($loaderDefinition) : void {
            $postTypes = $loaderDefinition->getArgument('$postTypes');
            $postTypes[$attribute->postType] = $reflectionClass->getName();
            $loaderDefinition->replaceArgument('$postTypes', $postTypes);
            $definition->setPublic(\true);
            $definition->setShared(\false);
            $definition->setAutoconfigured(\true);
            $definition->setAutowired(\true);
        });
        $builder->register(Page::class, Page::class)->setAutoconfigured(\true)->setAutowired(\true);
        $builder->register(Post::class, Post::class)->setAutoconfigured(\true)->setAutowired(\true);
        $builder->register(NavMenuItem::class, NavMenuItem::class)->setAutoconfigured(\true)->setAutowired(\true);
    }
    private function registerTemplate(ContainerBuilder $builder) : void
    {
        $builder->registerAttributeForAutoconfiguration(IsTemplate::class, static function (ChildDefinition $definition, IsTemplate $attribute) : void {
            $definition->setArgument('$templateFile', $attribute->templateFile);
        });
        $builder->registerAttributeForAutoconfiguration(UseScript::class, static function (ChildDefinition $definition, UseScript $attribute) : void {
            $definition->addMethodCall('addScript', ['$src' => $attribute->src, '$deps' => $attribute->deps, '$adminAjaxActions' => $attribute->adminAjaxActions]);
        });
        $builder->registerAttributeForAutoconfiguration(UseAdminAjax::class, static function (ChildDefinition $definition, UseAdminAjax $attribute) : void {
            $definition->addMethodCall('registerAdminAjaxAction', ['$action' => $attribute->actionName]);
        });
        $builder->register(Notice::class, Notice::class)->setAutoconfigured(\true)->setAutowired(\true);
        $builder->setAlias('template.notice', Notice::class)->setPublic(\true);
        $builder->register(GlobalContext::class, GlobalContext::class)->setPublic(\true);
    }
    private function registerTemplateRenderer(ContainerBuilder $builder) : void
    {
        // Register handler
        $builder->register(NamespaceHandler::class, NamespaceHandler::class)->setAutowired(\true);
        $builder->register(FunctionHandler::class, FunctionHandler::class)->setAutowired(\true);
        // Register built in template functions
        $builder->register(Wordpress::class, Wordpress::class)->setAutowired(\true)->addTag('template.functions');
        $builder->register(TemplateRenderer::class, TemplateRenderer::class)->setPublic(\true)->setAutowired(\true);
        $builder->setAlias('template.renderer', TemplateRenderer::class)->setPublic(\true);
        // PHTML Engine
        $builder->register(PHTMLEngine::class, PHTMLEngine::class)->setPublic(\true)->setAutowired(\true)->addTag('template.engine');
        // Twig Engine
        $builder->register(FileLoader::class, FileLoader::class)->setAutowired(\true);
        $builder->register(Extension::class, Extension::class)->setAutowired(\true);
        $builder->register(TwigEngine::class, TwigEngine::class)->setPublic('true')->setAutowired(\true)->addTag('template.engine');
        $builder->registerAttributeForAutoconfiguration(AsTemplateEngine::class, static function (ChildDefinition $definition) : void {
            $definition->addTag('template.engine');
        });
        $builder->registerAttributeForAutoconfiguration(AsFunctionContainer::class, static function (ChildDefinition $definition) : void {
            $definition->addTag('template.functions');
        });
        $builder->addCompilerPass(new EngineCompilerPass());
        $builder->addCompilerPass(new FunctionCompilerPass());
    }
    private function registerSettingsContainer(ContainerBuilder $builder) : void
    {
        $builder->addCompilerPass(new SettingCompilerpass());
        $builder->registerAttributeForAutoconfiguration(AsSettingContainer::class, static function (ChildDefinition $defintion) : void {
            $defintion->addTag('setting.container');
        });
    }
    private function registerAdminAjaxContainer(ContainerBuilder $builder) : void
    {
        $builder->register('adminajax.loader', AdminAjaxLoader::class)->setPublic(\true)->setAutowired(\true);
        $builder->addCompilerPass(new AdminAjaxLoaderCompilerPass());
        $builder->registerAttributeForAutoconfiguration(AsAdminAjaxContainer::class, static function (ChildDefinition $defintion) : void {
            $defintion->addTag('adminajax.container');
        });
    }
    private function registerAdminPages(ContainerBuilder $builder) : void
    {
        $builder->addCompilerPass(new TabbedPageCompilerPass());
        $builder->registerAttributeForAutoconfiguration(IsTabbedPage::class, static function (ChildDefinition $defintion) : void {
            $defintion->addTag('adminpages.tabbed');
        });
        $builder->register(TabbedPageTemplate::class, TabbedPageTemplate::class)->setAutoconfigured(\true)->setAutowired(\true);
    }
    private function registerMenuContainer(ContainerBuilder $builder) : void
    {
        $builder->register('menu.loader', MenuLoader::class)->setPublic(\true)->setAutowired(\true);
        $builder->addCompilerPass(new MenuLoaderCompilerPass());
        $builder->registerAttributeForAutoconfiguration(AsMenuContainer::class, static function (ChildDefinition $definition) : void {
            $definition->addTag('menu.container');
        });
    }
    private function registerShortcodeContainer(ContainerBuilder $builder) : void
    {
        $builder->register('shortcode.loader', ShortcodeLoader::class)->setPublic(\true)->setAutowired(\true);
        $builder->addCompilerPass(new ShortcodeLoaderCompilerPass());
        $builder->registerAttributeForAutoconfiguration(AsShortcodeContainer::class, static function (ChildDefinition $defintion) : void {
            $defintion->addTag('shortcode.container');
        });
    }
    private function registerHookContainer(ContainerBuilder $builder) : void
    {
        $builder->register('hook.loader', HookLoader::class)->setPublic(\true)->setAutowired(\true);
        $builder->addCompilerPass(new HookLoaderCompilerPass());
        $builder->registerAttributeForAutoconfiguration(AsHookContainer::class, static function (ChildDefinition $definition) : void {
            $definition->addTag('hook.container');
        });
    }
    private function registerMetaboxContainer(ContainerBuilder $builder)
    {
        $builder->register('metabox.loader', MetaboxLoader::class)->setPublic(\true)->setAutowired(\true);
        $builder->addCompilerPass(new MetaboxLoaderCompilerPass());
        $builder->registerAttributeForAutoconfiguration(AsMetaboxContainer::class, static function (ChildDefinition $definition) : void {
            $definition->addTag('metabox.container');
        });
    }
    private function registerBulkeditContainer(ContainerBuilder $builder)
    {
        $builder->register('bulkedit.loader', BulkeditLoader::class)->setPublic(\true)->setAutowired(\true);
        $builder->addCompilerPass(new BulkeditLoaderCompilerPass());
        $builder->registerAttributeForAutoconfiguration(AsBulkEditContainer::class, static function (ChildDefinition $definition) : void {
            $definition->addTag('bulkedit.container');
        });
    }
    private function registerGutenbergBlock(ContainerBuilder $builder) : void
    {
        $builder->register('gutenbergblock.loader', GutenbergBlockLoader::class)->setPublic(\true)->setAutowired(\true);
        $builder->addCompilerPass(new GutenbergBlockCompilerPass());
        $builder->registerAttributeForAutoconfiguration(AsDynamicBlock::class, static function (ChildDefinition $definition) : void {
            $definition->addTag('gutenbergblock.dynamicblock');
        });
    }
    private function registerRestAPIContainer(ContainerBuilder $builder) : void
    {
        $builder->register('restapi.loader', RestAPILoader::class)->setPublic(\true)->setAutowired(\true);
        $builder->addCompilerPass(new RestAPILoaderCompilerPass());
        $builder->registerAttributeForAutoconfiguration(AsRestContainer::class, static function (ChildDefinition $definition) : void {
            $definition->addTag('restapi.container');
        });
    }
}
