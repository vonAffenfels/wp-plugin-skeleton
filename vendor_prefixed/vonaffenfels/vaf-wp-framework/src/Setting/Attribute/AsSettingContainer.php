<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Setting\Attribute;

use Attribute;
/** @internal */
#[Attribute(Attribute::TARGET_CLASS)]
class AsSettingContainer
{
    public function __construct(public readonly string $name, public readonly mixed $default = null)
    {
    }
}
