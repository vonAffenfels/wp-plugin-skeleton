<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Template\Attribute;

use Attribute;
/** @internal */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class UseAdminAjax
{
    public function __construct(public readonly string $actionName)
    {
    }
}
