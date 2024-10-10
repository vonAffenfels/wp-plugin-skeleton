<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\BulkEdit\Attribute;

use Attribute;
/** @internal */
#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class BulkEdit
{
    public function __construct(public readonly string $title, public readonly string|array|null $postTypes = null, public readonly string|null $supporting = null)
    {
    }
}
