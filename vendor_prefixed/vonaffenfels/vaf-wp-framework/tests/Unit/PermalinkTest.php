<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\FrameworkTests\Unit;

use WPPluginSkeleton_Vendor\VAF\WP\Framework\Permalink\Permalink;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Permalink\PermalinkResolver;
use WPPluginSkeleton_Vendor\VAF\WP\FrameworkTests\TestCase;
/** @internal */
class PermalinkTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_able_to_fake_permalink_before_creating_permalink()
    {
        $resolver = \WPPluginSkeleton_Vendor\Mockery::mock(PermalinkResolver::class);
        $resolver->shouldReceive('permalinkForPostId')->with(15)->andReturn('expected permalink');
        Permalink::fake($resolver);
        $permalink = Permalink::fromPostId(15);
        $this->assertEquals('expected permalink', (string) $permalink);
    }
    /**
     * @test
     */
    public function should_be_able_to_fake_permalink_after_creating_permalink()
    {
        $resolver = \WPPluginSkeleton_Vendor\Mockery::mock(PermalinkResolver::class);
        $resolver->shouldReceive('permalinkForPostId')->with(15)->andReturn('expected permalink');
        $permalink = Permalink::fromPostId(15);
        Permalink::fake($resolver);
        $this->assertEquals('expected permalink', (string) $permalink);
    }
    /**
     * @test
     */
    public function should_be_able_to_easily_fake_a_passthrough_url()
    {
        Permalink::fakePassthrough();
        $permalink = Permalink::fromPostId(15);
        $this->assertEquals('permalink_for_15', (string) $permalink);
    }
}
