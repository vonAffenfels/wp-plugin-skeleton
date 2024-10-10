<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects\Attributes;

use Attribute;
/** @internal */
#[Attribute(Attribute::TARGET_CLASS)]
final class PostTypeExtension
{
    public array $postTypes = [];
    public function __construct(array|string $postTypes = [])
    {
        $this->postTypes = !\is_array($postTypes) ? [$postTypes] : $postTypes;
    }
}
