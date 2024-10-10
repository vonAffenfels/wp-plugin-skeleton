<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\GutenbergBlock\Attribute;

use Attribute;
/** @internal */
#[Attribute(Attribute::TARGET_CLASS)]
class AsDynamicBlock
{
    public function __construct(public readonly string $blockType, public readonly string $editorScriptHandle, public readonly int $version = 2, public readonly array $attributes = [])
    {
    }
}
