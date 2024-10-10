<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils\Templates\Admin;

use WPPluginSkeleton_Vendor\VAF\WP\Framework\Template\Attribute\IsTemplate;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Template\Template;
/** @internal */
#[IsTemplate('@vaf-wp-framework/react')]
class ReactTemplate extends Template
{
    private string $id = 'not set';
    private array $initialData = [];
    public function withId(string $id) : self
    {
        $this->id = $id;
        return $this;
    }
    public function withInitialData(array $initialData) : self
    {
        $this->initialData = $initialData;
        return $this;
    }
    protected function getContextData() : array
    {
        return ['id' => $this->id, 'initialData' => $this->initialData];
    }
}
