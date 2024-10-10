<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Engine;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\TwigFunction;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Attribute\AsTemplateEngine;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Engine\TwigRenderer\Extension;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Engine\TwigRenderer\FileLoader;
/** @internal */
#[AsTemplateEngine(extension: 'twig')]
final class TwigEngine extends TemplateEngine
{
    private Environment $twig;
    public function __construct(FileLoader $loader, Extension $extension)
    {
        $this->twig = new Environment($loader);
        $this->twig->enableDebug();
        $this->twig->addExtension($extension);
    }
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function render(string $file, array $context) : string
    {
        if ($this->isDebug()) {
            $this->twig->enableDebug();
        }
        return $this->twig->render($file, $context);
    }
}
