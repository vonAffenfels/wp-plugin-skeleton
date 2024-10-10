<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Permalink;

/** @internal */
class PermalinkPassthroughResolver extends PermalinkResolver
{
    public function permalinkForPostId(string $postId) : string
    {
        return "permalink_for_{$postId}";
    }
}
