<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\FrameworkTests\Unit;

use WPPluginSkeleton_Vendor\VAF\WP\Framework\Metabox\MetaboxId;
use WPPluginSkeleton_Vendor\VAF\WP\FrameworkTests\TestCase;
/** @internal */
class MetaboxIdTest extends TestCase
{
    /**
     * @test
     */
    public function should_generate_classname_without_namespace_underscore_methodname()
    {
        $id = (string) MetaboxId::fromClassMethodName('WPPluginSkeleton_Vendor\\Namespace\\Subnamespace\\Classname', 'methodName');
        $this->assertEquals('classname_methodname', $id);
    }
}
