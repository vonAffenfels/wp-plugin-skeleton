<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WPPluginSkeleton_Vendor\Symfony\Component\Config\Definition\Builder;

use WPPluginSkeleton_Vendor\Symfony\Component\Config\Definition\ScalarNode;
/**
 * This class provides a fluent interface for defining a node.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 * @internal
 */
class ScalarNodeDefinition extends VariableNodeDefinition
{
    /**
     * Instantiate a Node.
     */
    protected function instantiateNode() : ScalarNode
    {
        return new ScalarNode($this->name, $this->parent, $this->pathSeparator);
    }
}
