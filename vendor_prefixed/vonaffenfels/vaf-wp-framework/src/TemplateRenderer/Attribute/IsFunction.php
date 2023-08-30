<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Attribute;

use Attribute;
#[Attribute(Attribute::TARGET_METHOD)]
class IsFunction
{
    public function __construct(public readonly string $name)
    {
    }
}
