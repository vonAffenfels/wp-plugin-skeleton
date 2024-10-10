<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\GutenbergBlock;

use WPPluginSkeleton_Vendor\VAF\WP\Framework\Kernel\WordpressKernel;
/** @internal */
final class Loader
{
    public function __construct(private readonly WordpressKernel $kernel, private readonly array $dynamicBlocks)
    {
    }
    public function registerBlocks() : void
    {
        foreach ($this->dynamicBlocks as $dynamicBlock) {
            $instance = $this->kernel->getContainer()->get($dynamicBlock['class']);
            register_block_type($dynamicBlock['type'], [...$dynamicBlock['options'], 'render_callback' => RendererDefinition::fromRendererDefinition($dynamicBlock['renderer'])->renderer($instance)]);
        }
    }
}
