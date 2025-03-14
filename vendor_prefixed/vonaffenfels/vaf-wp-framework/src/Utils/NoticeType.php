<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils;

/** @internal */
enum NoticeType : string
{
    case ERROR = 'notice-error';
    case WARNING = 'notice-warning';
    case SUCCESS = 'notice-success';
    case INFO = 'notice-info';
}
