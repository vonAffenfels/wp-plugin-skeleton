<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils\Templates\Admin;

use WPPluginSkeleton_Vendor\VAF\WP\Framework\Template\Attribute\IsTemplate;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Template\Template;
#[IsTemplate(templateFile: '@vaf-wp-framework/admin/tabbedPage')]
final class TabbedPage extends Template
{
    private string $pageTitle = '';
    private array $tabs = [];
    private string $content = '';
    public function setPageTitle(string $title) : self
    {
        $this->pageTitle = $title;
        return $this;
    }
    public function setTabs(array $tabs) : self
    {
        $this->tabs = $tabs;
        return $this;
    }
    public function setContent(string $content) : self
    {
        $this->content = $content;
        return $this;
    }
    protected function getContextData() : array
    {
        return ['pageTitle' => $this->pageTitle, 'tabs' => $this->tabs, 'content' => $this->content];
    }
}
