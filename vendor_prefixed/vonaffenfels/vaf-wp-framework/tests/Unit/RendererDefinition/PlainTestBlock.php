<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\FrameworkTests\Unit\RendererDefinition;

/** @internal */
class PlainTestBlock
{
    public mixed $calledWith = null;
    public function render($blockAttributes, string $content) : string
    {
        $this->calledWith = $blockAttributes;
        return $content;
    }
}
