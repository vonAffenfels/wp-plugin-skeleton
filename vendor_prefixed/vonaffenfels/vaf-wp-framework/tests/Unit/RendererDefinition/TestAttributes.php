<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\FrameworkTests\Unit\RendererDefinition;

/** @internal */
class TestAttributes
{
    public readonly string $test;
    public static function fromBlockAttributes($blockAttributes) : self
    {
        $testAttributes = new static();
        $testAttributes->test = $blockAttributes['test'] ?? 'not set';
        return $testAttributes;
    }
}
