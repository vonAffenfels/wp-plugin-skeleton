<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Engine\Twig;

use WPPluginSkeleton_Vendor\Twig\Extension\AbstractExtension;
use WPPluginSkeleton_Vendor\Twig\TwigFunction;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\FunctionHandler;
class Extension extends AbstractExtension
{
    public function __construct(private readonly FunctionHandler $functionHandler)
    {
    }
    public function getFunctions() : array
    {
        $registeredFunctions = [];
        foreach ($this->functionHandler->getRegisteredFunctions() as $registeredFunction) {
            $registeredFunctions[] = new TwigFunction($registeredFunction, function (...$args) use($registeredFunction) {
                return $this->functionHandler->call($registeredFunction, $args);
            });
        }
        return $registeredFunctions;
    }
}
