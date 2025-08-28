<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\QuickEdit;

/** @internal */
class QuickEditPostDataEvent
{
    public function __construct(public readonly int $postId, public readonly string $columnName)
    {
    }
}
