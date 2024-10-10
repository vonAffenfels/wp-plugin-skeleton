<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\RestAPI\Attribute;

use Attribute;
/**
 * Service tag to autoconfigure rest API container.
 * @internal
 */
#[Attribute(Attribute::TARGET_CLASS)]
class AsRestContainer
{
    public function __construct(public readonly string $namespace = '')
    {
    }
}
