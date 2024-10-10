<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Template\Attribute;

use Attribute;
/** @internal */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class UseScript
{
    public function __construct(public readonly string $src, public readonly array $deps = [], public readonly array $adminAjaxActions = [])
    {
    }
}
