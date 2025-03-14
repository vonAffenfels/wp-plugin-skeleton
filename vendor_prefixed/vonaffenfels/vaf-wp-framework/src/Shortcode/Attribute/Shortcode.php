<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Shortcode\Attribute;

use Attribute;
/** @internal */
#[Attribute(Attribute::TARGET_METHOD)]
class Shortcode
{
    public function __construct(public readonly string $tag)
    {
    }
}
