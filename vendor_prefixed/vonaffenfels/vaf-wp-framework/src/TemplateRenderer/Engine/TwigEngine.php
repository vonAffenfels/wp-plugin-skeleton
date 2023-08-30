<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Engine;

use WPPluginSkeleton_Vendor\Twig\Environment;
use WPPluginSkeleton_Vendor\Twig\Error\LoaderError;
use WPPluginSkeleton_Vendor\Twig\Error\RuntimeError;
use WPPluginSkeleton_Vendor\Twig\Error\SyntaxError;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Attribute\AsTemplateEngine;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Engine\Twig\Extension;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Engine\Twig\FileLoader;
#[AsTemplateEngine(extension: 'twig')]
final class TwigEngine extends TemplateEngine
{
    private Environment $twig;
    public function __construct(FileLoader $loader, Extension $extension)
    {
        $this->twig = new Environment($loader);
        $this->twig->addExtension($extension);
    }
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function render(string $file, array $context) : string
    {
        return $this->twig->render($file, $context);
    }
}
