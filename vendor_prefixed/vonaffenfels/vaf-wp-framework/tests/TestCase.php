<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\FrameworkTests;

use WPPluginSkeleton_Vendor\Mockery\Adapter\Phpunit\MockeryTestCase;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Filter\Filter;
/** @internal */
class TestCase extends MockeryTestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        Filter::resetFake();
    }
}
