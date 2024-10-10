<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Functions\BuiltIn;

use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Attribute\AsFunctionContainer;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\TemplateRenderer\Attribute\IsFunction;
/** @internal */
#[AsFunctionContainer]
class Wordpress
{
    #[IsFunction('wp_head')]
    public function wpHead() : void
    {
        wp_head();
    }
    #[IsFunction('get_bloginfo', safeHTML: \true)]
    public function getBlogInfo(...$parameter) : string
    {
        return get_bloginfo(...$parameter);
    }
    #[IsFunction('wp_editor')]
    public function wpEditor(...$parameter) : void
    {
        wp_editor(...$parameter);
    }
    #[IsFunction('wp_nonce_field')]
    public function wpNonceField(...$parameter) : string
    {
        return wp_nonce_field(...$parameter);
    }
    #[IsFunction('__')]
    public function __(...$parameter) : string
    {
        return __(...$parameter);
    }
    #[IsFunction('do_shortcode')]
    public function doShortcode(...$parameter) : void
    {
        do_shortcode(...$parameter);
    }
    #[IsFunction('wp_footer')]
    public function wpFooter() : void
    {
        wp_footer();
    }
    #[IsFunction('wp_title')]
    public function wpTitle() : void
    {
        wp_title();
    }
    #[IsFunction('is_admin_bar_showing')]
    public function isAdminBarShowing() : bool
    {
        return is_admin_bar_showing();
    }
    #[IsFunction('get_home_url')]
    public function getHomeUrl(...$parameter) : string
    {
        return get_home_url(...$parameter);
    }
    #[IsFunction('sanitize_title')]
    public function sanitizeTitle(...$parameter) : string
    {
        return sanitize_title(...$parameter);
    }
}
