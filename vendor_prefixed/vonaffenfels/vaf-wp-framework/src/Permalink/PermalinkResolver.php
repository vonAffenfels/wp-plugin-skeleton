<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Permalink;

/** @internal */
class PermalinkResolver
{
    public function permalinkForPostId(string $postId) : string
    {
        return get_permalink($postId);
    }
}
