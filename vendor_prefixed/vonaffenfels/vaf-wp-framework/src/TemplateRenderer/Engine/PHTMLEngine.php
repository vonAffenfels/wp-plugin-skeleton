<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Engine;

use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Attribute\AsTemplateEngine;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\FunctionHandler;
/** @internal */
#[AsTemplateEngine(extension: 'phtml')]
final class PHTMLEngine extends TemplateEngine
{
    public function __construct(private readonly FunctionHandler $functionHandler)
    {
    }
    private array $data = [];
    public function render(string $file, array $context) : string
    {
        $this->data = $context;
        unset($context);
        \ob_start();
        include $file;
        return \ob_get_clean();
    }
    public function getData(string $name, $default = null)
    {
        if (!isset($this->data[$name])) {
            return $default;
        }
        return $this->data[$name];
    }
    public function __get(string $name)
    {
        return $this->getData($name);
    }
    public function __isset(string $name)
    {
        return isset($this->data[$name]);
    }
    public function __call(string $name, array $args) : mixed
    {
        return $this->functionHandler->call($name, $args);
    }
}
