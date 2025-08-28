<?php

namespace WPPluginSkeleton_Vendor;

uses(\WPPluginSkeleton_Vendor\VAF\WP\FrameworkTests\TestCase::class);
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Metabox\MetaboxId;
test('should generate classname without namespace underscore methodname', function () {
    $id = (string) MetaboxId::fromClassMethodName('WPPluginSkeleton_Vendor\\Namespace\\Subnamespace\\Classname', 'methodName');
    expect($id)->toEqual('classname_methodname');
});
