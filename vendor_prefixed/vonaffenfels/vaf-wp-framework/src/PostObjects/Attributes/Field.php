<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\Attributes;

use Attribute;
/** @internal */
#[Attribute(Attribute::TARGET_METHOD)]
class Field
{
    public function __construct(public readonly string $fieldName)
    {
    }
}
