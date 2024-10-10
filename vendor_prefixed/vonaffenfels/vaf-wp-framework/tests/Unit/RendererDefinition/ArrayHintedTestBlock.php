<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\FrameworkTests\Unit\RendererDefinition;

/** @internal */
class ArrayHintedTestBlock
{
    public ?array $calledWith = null;
    public function render(array $blockAttributes, string $content) : string
    {
        $this->calledWith = $blockAttributes;
        return $content;
    }
}
