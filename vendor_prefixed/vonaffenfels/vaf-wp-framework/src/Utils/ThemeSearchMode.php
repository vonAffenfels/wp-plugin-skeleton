<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils;

enum ThemeSearchMode : string
{
    case ALL = 'all';
    case PARENT_ONLY = 'parentOnly';
    case CURRENT_ONLY = 'currentOnly';
}
