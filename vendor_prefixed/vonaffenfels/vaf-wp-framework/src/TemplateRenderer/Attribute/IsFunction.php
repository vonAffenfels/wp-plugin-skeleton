<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Attribute;

use Attribute;
/** @internal */
#[Attribute(Attribute::TARGET_METHOD)]
class IsFunction
{
    public function __construct(public readonly string $name, public readonly bool $safeHTML = \false)
    {
    }
}
