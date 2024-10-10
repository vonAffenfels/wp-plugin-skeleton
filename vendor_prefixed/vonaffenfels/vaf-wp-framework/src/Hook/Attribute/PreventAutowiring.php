<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Hook\Attribute;

use Attribute;
/** @internal */
#[Attribute(Attribute::TARGET_PARAMETER)]
final class PreventAutowiring
{
    public function __construct()
    {
    }
}
