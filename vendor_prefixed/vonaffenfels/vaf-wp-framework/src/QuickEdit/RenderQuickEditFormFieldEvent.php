<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\QuickEdit;

/** @internal */
class RenderQuickEditFormFieldEvent
{
    public function __construct(public readonly string $columnName)
    {
    }
}
