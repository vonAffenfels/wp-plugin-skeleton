<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WPPluginSkeleton_Vendor\Twig\Test;

use WPPluginSkeleton_Vendor\PHPUnit\Framework\TestCase;
use WPPluginSkeleton_Vendor\Twig\Compiler;
use WPPluginSkeleton_Vendor\Twig\Environment;
use WPPluginSkeleton_Vendor\Twig\Loader\ArrayLoader;
use WPPluginSkeleton_Vendor\Twig\Node\Node;
abstract class NodeTestCase extends TestCase
{
    public abstract function getTests();
    /**
     * @dataProvider getTests
     */
    public function testCompile($node, $source, $environment = null, $isPattern = \false)
    {
        $this->assertNodeCompilation($source, $node, $environment, $isPattern);
    }
    public function assertNodeCompilation($source, Node $node, Environment $environment = null, $isPattern = \false)
    {
        $compiler = $this->getCompiler($environment);
        $compiler->compile($node);
        if ($isPattern) {
            $this->assertStringMatchesFormat($source, \trim($compiler->getSource()));
        } else {
            $this->assertEquals($source, \trim($compiler->getSource()));
        }
    }
    protected function getCompiler(Environment $environment = null)
    {
        return new Compiler(null === $environment ? $this->getEnvironment() : $environment);
    }
    protected function getEnvironment()
    {
        return new Environment(new ArrayLoader([]));
    }
    protected function getVariableGetter($name, $line = \false)
    {
        $line = $line > 0 ? "// line {$line}\n" : '';
        return \sprintf('%s($context["%s"] ?? null)', $line, $name);
    }
    protected function getAttributeGetter()
    {
        return 'twig_get_attribute($this->env, $this->source, ';
    }
}
