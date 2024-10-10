<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Menu\Attribute;

use Attribute;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils\Capabilities;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils\Dashicons;
/** @internal */
#[Attribute(Attribute::TARGET_METHOD)]
class MenuItem
{
    public function __construct(public readonly string $menuTitle, public readonly Capabilities $capability, public readonly string $slug, public Dashicons|string $icon = '', public ?int $position = null, public string $parent = '', public string $subMenuTitle = '')
    {
    }
}
