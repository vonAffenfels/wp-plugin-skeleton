<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\CustomColumn;

use WPPluginSkeleton_Vendor\VAF\WP\Framework\Kernel\WordpressKernel;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\PostTypeList;
/** @internal */
final class Loader
{
    public function __construct(private readonly WordpressKernel $kernel, private readonly array $customColumnContainer)
    {
    }
    public function registerCustomColumnFields() : void
    {
        foreach ($this->customColumnContainer as $serviceId => $customColumnContainer) {
            foreach ($customColumnContainer as $data) {
                $this->registerCustomColumnField($serviceId, $data);
            }
        }
    }
    private function registerCustomColumnField($serviceId, $data)
    {
        add_action('admin_init', function () use($data, $serviceId) {
            $postTypes = PostTypeList::fromPostTypes($data['postTypes'])->withSupporting($data['supporting'], fn($feature) => get_post_types_by_support($feature))->postTypes();
            foreach ($postTypes as $postType) {
                add_action("manage_edit-{$postType}_columns", function ($columns) use($data) {
                    return [...$columns, $data['name'] => $data['title']];
                }, 9999);
                add_action("manage_{$postType}_posts_custom_column", function ($columnName, $postId) use($data, $serviceId) {
                    if ($columnName !== $data['name']) {
                        return;
                    }
                    $methodName = $data['method'];
                    echo $this->kernel->getContainer()->get($serviceId)->{$methodName}($postId);
                }, 9999, accepted_args: 2);
            }
        });
    }
}
