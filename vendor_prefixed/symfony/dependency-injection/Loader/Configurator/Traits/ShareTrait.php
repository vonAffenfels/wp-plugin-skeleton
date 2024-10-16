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
trait ShareTrait
{
    /**
     * Sets if the service must be shared or not.
     *
     * @return $this
     */
    public final function share(bool $shared = \true) : static
    {
        $this->definition->setShared($shared);
        return $this;
    }
}
