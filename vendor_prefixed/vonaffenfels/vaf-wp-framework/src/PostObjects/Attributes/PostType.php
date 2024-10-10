<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\Attributes;

use Attribute;
/** @internal */
#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS)]
class PostType
{
    public function __construct(public readonly string $postType)
    {
    }
}
