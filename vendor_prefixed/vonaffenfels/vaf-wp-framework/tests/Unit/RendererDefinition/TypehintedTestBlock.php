<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\FrameworkTests\Unit\RendererDefinition;

/** @internal */
class TypehintedTestBlock
{
    public ?TestAttributes $calledWith = null;
    public function render(TestAttributes $attributes, string $content) : string
    {
        $this->calledWith = $attributes;
        return '';
    }
}
