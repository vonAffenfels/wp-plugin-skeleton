<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\AdminPages;

use WPPluginSkeleton_Vendor\VAF\WP\Framework\BaseWordpress;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Kernel\WordpressKernel;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Request;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\System\Parameters\Parameter;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\System\Parameters\ParameterBag;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils\Templates\Admin\TabbedPage as Template;
/** @internal */
abstract class TabbedPage
{
    public final function __construct(private readonly string $pageTitle, private readonly string $pageVar, private readonly ?string $defaultSlug, private array $handler, private readonly Request $request, private readonly Template $template, private readonly WordpressKernel $kernel, private readonly BaseWordpress $base)
    {
    }
    private function buildUrl(string $slug) : string
    {
        return add_query_arg([$this->pageVar => $slug], admin_url('admin.php'));
    }
    private function getPageContent(string $method, array $paramBag) : string
    {
        $parameterBag = ParameterBag::fromArray($paramBag);
        $params = [];
        /** @var Parameter $parameter */
        foreach ($parameterBag->getParams() as $parameter) {
            if (!$parameter->isServiceParam()) {
                continue;
            }
            $params[$parameter->getName()] = $this->kernel->getContainer()->get($parameter->getType());
        }
        \ob_start();
        $content = $this->{$method}(...$params);
        $contentEcho = \ob_get_clean();
        return $content ?: $contentEcho;
    }
    public final function handle() : void
    {
        $firstTab = \reset($this->handler);
        $page = $this->request->getParam($this->pageVar, Request::TYPE_GET, $this->defaultSlug ?? $firstTab['slug']);
        $tabs = [];
        foreach ($this->handler as $tab) {
            $tabs[] = ['active' => $tab['slug'] === $page, 'title' => $tab['title'], 'url' => $this->buildUrl($tab['slug'])];
        }
        if (isset($this->handler[$page])) {
            $this->template->setContent($this->getPageContent($this->handler[$page]['method'], $this->handler[$page]['params']));
        }
        $this->template->setTabs($tabs);
        $this->template->setPageTitle(__($this->pageTitle, $this->base->getName()));
        $this->template->output();
    }
}
