<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Engine;

/** @internal */
abstract class TemplateEngine
{
    private bool $debug = \false;
    public function enableDebug() : void
    {
        $this->debug = \true;
    }
    public function isDebug() : bool
    {
        return $this->debug;
    }
    public abstract function render(string $file, array $context) : string;
}
