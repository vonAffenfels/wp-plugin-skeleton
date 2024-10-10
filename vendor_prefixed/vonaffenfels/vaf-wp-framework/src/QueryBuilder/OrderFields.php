<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\QueryBuilder;

/** @internal */
enum OrderFields : string
{
    case NONE = 'none';
    case ID = 'ID';
    case AUTHOR = 'author';
    case TITLE = 'title';
    case POST_TYPE = 'type';
    case DATE = 'date';
    case MODIFIED_DATE = 'modified';
    case PARENT_ID = 'parent';
    case RANDOM = 'rand';
    case COMMENT_COUNT = 'comment_count';
    case POST_FILTER = 'post__in';
}
