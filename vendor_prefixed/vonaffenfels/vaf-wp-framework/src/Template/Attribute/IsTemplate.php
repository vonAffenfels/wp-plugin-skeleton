<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Template\Attribute;

use Attribute;
/** @internal */
#[Attribute(Attribute::TARGET_CLASS)]
class IsTemplate
{
    public function __construct(public readonly string $templateFile)
    {
    }
}
