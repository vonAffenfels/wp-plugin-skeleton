<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WPPluginSkeleton_Vendor\Symfony\Component\DependencyInjection\Loader\Configurator\Traits;

/** @internal */
trait FileTrait
{
    /**
     * Sets a file to require before creating the service.
     *
     * @return $this
     */
    public final function file(string $file) : static
    {
        $this->definition->setFile($file);
        return $this;
    }
}
