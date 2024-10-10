<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Attribute;

use Attribute;
/** @internal */
#[Attribute(Attribute::TARGET_CLASS)]
class AsTemplateEngine
{
    public function __construct(public readonly string $extension)
    {
    }
}
