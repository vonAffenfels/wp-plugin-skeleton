<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Facade\Attribute;

use Attribute;
/** @internal */
#[Attribute(Attribute::TARGET_CLASS)]
class AsFacade
{
    public function __construct(public readonly string $facadeAccessor)
    {
    }
}
