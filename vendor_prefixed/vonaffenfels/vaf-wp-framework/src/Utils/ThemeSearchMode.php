<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils;

/** @internal */
enum ThemeSearchMode : string
{
    case ALL = 'all';
    case PARENT_ONLY = 'parentOnly';
    case CURRENT_ONLY = 'currentOnly';
}
