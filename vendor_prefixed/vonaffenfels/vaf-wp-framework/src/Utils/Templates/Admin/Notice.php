<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils\Templates\Admin;

use WPPluginSkeleton_Vendor\VAF\WP\Framework\Template\Attribute\IsTemplate;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Template\Template;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils\NoticeType;
#[IsTemplate(templateFile: '@vaf-wp-framework/admin/notice')]
final class Notice extends Template
{
    private string $content = '';
    private bool $isDismissible = \true;
    private NoticeType $type = NoticeType::INFO;
    protected function getContextData() : array
    {
        return ['content' => $this->content, 'isDismissible' => $this->isDismissible, 'type' => $this->type];
    }
    public function setContent(string $content) : self
    {
        $this->content = $content;
        return $this;
    }
    public function setIsDismissible(bool $value) : self
    {
        $this->isDismissible = $value;
        return $this;
    }
    public function setType(NoticeType $type) : self
    {
        $this->type = $type;
        return $this;
    }
}
