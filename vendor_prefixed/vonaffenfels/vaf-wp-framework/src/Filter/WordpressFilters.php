<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Filter;

/** @internal */
class WordpressFilters
{
    public function resultFrom($name, ...$args)
    {
        return apply_filters($name, ...$args);
    }
}
