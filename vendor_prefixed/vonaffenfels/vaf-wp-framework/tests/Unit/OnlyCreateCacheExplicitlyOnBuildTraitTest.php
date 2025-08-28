<?php

namespace WPPluginSkeleton_Vendor;

use WPPluginSkeleton_Vendor\VAF\WP\Framework\Plugin;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Theme;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Traits\OnlyCreateCacheExplicitlyOnBuild;
// Test Plugin without trait
/** @internal */
class TestPluginWithoutTrait extends Plugin
{
    public static function testPreventAutomaticContainerCache() : bool
    {
        return static::preventAutomaticContainerCache();
    }
}
// Test Plugin without trait
/** @internal */
\class_alias('WPPluginSkeleton_Vendor\\TestPluginWithoutTrait', 'TestPluginWithoutTrait', \false);
// Test Plugin with trait
/** @internal */
class TestPluginWithTrait extends Plugin
{
    use OnlyCreateCacheExplicitlyOnBuild;
    public static function testPreventAutomaticContainerCache() : bool
    {
        return static::preventAutomaticContainerCache();
    }
}
// Test Plugin with trait
/** @internal */
\class_alias('WPPluginSkeleton_Vendor\\TestPluginWithTrait', 'TestPluginWithTrait', \false);
// Test Theme without trait
/** @internal */
class TestThemeWithoutTrait extends Theme
{
    public static function testPreventAutomaticContainerCache() : bool
    {
        return static::preventAutomaticContainerCache();
    }
}
// Test Theme without trait
/** @internal */
\class_alias('WPPluginSkeleton_Vendor\\TestThemeWithoutTrait', 'TestThemeWithoutTrait', \false);
// Test Theme with trait
/** @internal */
class TestThemeWithTrait extends Theme
{
    use OnlyCreateCacheExplicitlyOnBuild;
    public static function testPreventAutomaticContainerCache() : bool
    {
        return static::preventAutomaticContainerCache();
    }
}
// Test Theme with trait
/** @internal */
\class_alias('WPPluginSkeleton_Vendor\\TestThemeWithTrait', 'TestThemeWithTrait', \false);
it('should return false by default for plugin without trait', function () {
    expect(TestPluginWithoutTrait::testPreventAutomaticContainerCache())->toBeFalse();
});
it('should return true for plugin with trait', function () {
    expect(TestPluginWithTrait::testPreventAutomaticContainerCache())->toBeTrue();
});
it('should return false by default for theme without trait', function () {
    expect(TestThemeWithoutTrait::testPreventAutomaticContainerCache())->toBeFalse();
});
it('should return true for theme with trait', function () {
    expect(TestThemeWithTrait::testPreventAutomaticContainerCache())->toBeTrue();
});
