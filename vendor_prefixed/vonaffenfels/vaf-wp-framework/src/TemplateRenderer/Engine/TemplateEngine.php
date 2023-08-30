<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Engine;

abstract class TemplateEngine
{
    public abstract function render(string $file, array $context) : string;
}
