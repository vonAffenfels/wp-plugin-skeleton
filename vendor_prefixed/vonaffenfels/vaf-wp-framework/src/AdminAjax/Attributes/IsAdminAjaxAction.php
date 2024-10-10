<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\AdminAjax\Attributes;

use Attribute;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils\Capabilities;
/** @internal */
#[Attribute(Attribute::TARGET_METHOD)]
class IsAdminAjaxAction
{
    public function __construct(public readonly string $action, public readonly ?Capabilities $capability = null)
    {
    }
}
