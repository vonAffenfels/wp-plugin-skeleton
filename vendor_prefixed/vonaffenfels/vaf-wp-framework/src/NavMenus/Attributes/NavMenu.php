<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\NavMenus\Attributes;

use Attribute;
/** @internal */
#[Attribute(Attribute::TARGET_CLASS)]
class NavMenu
{
    public function __construct(public readonly string $slug, public readonly string $description)
    {
    }
}
