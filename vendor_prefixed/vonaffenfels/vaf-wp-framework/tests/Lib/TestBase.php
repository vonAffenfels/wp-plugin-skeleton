<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\FrameworkTests\Lib;

use WPPluginSkeleton_Vendor\Mockery;
/** @internal */
class TestBase extends \WPPluginSkeleton_Vendor\VAF\WP\Framework\BaseWordpress
{
    public static function forName(string $name)
    {
        return new self($name, '', '');
    }
    protected function createKernel() : \WPPluginSkeleton_Vendor\VAF\WP\Framework\Kernel\Kernel
    {
        return Mockery::mock(\WPPluginSkeleton_Vendor\VAF\WP\Framework\Kernel\Kernel::class);
    }
}
