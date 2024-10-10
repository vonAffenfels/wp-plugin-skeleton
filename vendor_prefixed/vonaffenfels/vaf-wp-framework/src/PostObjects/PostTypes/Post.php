<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\PostTypes;

use WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\Attributes\PostType;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\PostObject;
/** @internal */
#[PostType(self::TYPE_NAME)]
class Post extends PostObject
{
    public const TYPE_NAME = 'post';
    public function getPermalink() : string
    {
        return get_permalink($this->getPost());
    }
    public function getTitle() : string
    {
        return get_the_title($this->getPost());
    }
}
