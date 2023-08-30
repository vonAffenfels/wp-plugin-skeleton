<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\RestAPI\Attribute;

use Attribute;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\RestAPI\RestRouteMethod;
#[Attribute(Attribute::TARGET_METHOD)]
class RestRoute
{
    public function __construct(public readonly string $uri, public readonly RestRouteMethod $method)
    {
    }
}
