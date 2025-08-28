<?php

namespace WPPluginSkeleton_Vendor;

uses(\WPPluginSkeleton_Vendor\VAF\WP\FrameworkTests\TestCase::class);
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Permalink\Permalink;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Permalink\PermalinkResolver;
test('should be able to fake permalink before creating permalink', function () {
    $resolver = \WPPluginSkeleton_Vendor\Mockery::mock(PermalinkResolver::class);
    $resolver->shouldReceive('permalinkForPostId')->with(15)->andReturn('expected permalink');
    Permalink::fake($resolver);
    $permalink = Permalink::fromPostId(15);
    expect((string) $permalink)->toEqual('expected permalink');
});
test('should be able to fake permalink after creating permalink', function () {
    $resolver = \WPPluginSkeleton_Vendor\Mockery::mock(PermalinkResolver::class);
    $resolver->shouldReceive('permalinkForPostId')->with(15)->andReturn('expected permalink');
    $permalink = Permalink::fromPostId(15);
    Permalink::fake($resolver);
    expect((string) $permalink)->toEqual('expected permalink');
});
test('should be able to easily fake a passthrough url', function () {
    Permalink::fakePassthrough();
    $permalink = Permalink::fromPostId(15);
    expect((string) $permalink)->toEqual('permalink_for_15');
});
