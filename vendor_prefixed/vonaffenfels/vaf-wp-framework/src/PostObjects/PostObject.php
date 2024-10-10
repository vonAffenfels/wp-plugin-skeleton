<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\PostObjects;

use LogicException;
use WPPluginSkeleton_Vendor\VAF\WP\Framework\Utils\ClassSystem;
use WPPluginSkeleton_Vendor\WP_Post;
/** @internal */
abstract class PostObject
{
    private array $data = [];
    private ?WP_Post $post = null;
    /******************
     * STATIC METHODS *
     ******************/
    public static function getByWPPost(WP_Post $post) : ?static
    {
        $obj = PostTypeLoader::getObjectForPostType($post->post_type);
        $obj->setPost($post);
        if (!ClassSystem::isExtendsOrImplements(static::class, \get_class($obj))) {
            // Make sure that we return a requested type
            return null;
        }
        return $obj;
    }
    public static function getById(int $postId) : ?static
    {
        $post = WP_Post::get_instance($postId);
        if (\false === $post) {
            return null;
        }
        return static::getByWPPost($post);
    }
    public static function currentPost() : ?static
    {
        $post = get_post();
        if (\false === $post) {
            return null;
        }
        return static::getByWPPost($post);
    }
    /********************
     * INSTANCE METHODS *
     ********************/
    private function setPost(WP_Post $post) : void
    {
        $this->post = $post;
    }
    protected function getPost() : WP_Post
    {
        if (\is_null($this->post)) {
            throw new LogicException('PostObject not initialized!');
        }
        return $this->post;
    }
    private function isJson(string $string) : bool
    {
        \json_decode($string);
        return \json_last_error() === \JSON_ERROR_NONE;
    }
    public function getMetadata(string $name) : mixed
    {
        $meta = get_post_meta($this->getPost()->ID, $name, \true);
        if (is_serialized($meta)) {
            $meta = @\unserialize(\trim($meta));
        } elseif ($this->isJson($meta)) {
            $meta = \json_decode($meta, \true);
        }
        return $meta;
    }
    public function get(string $name) : mixed
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        // $obj->get('post_title');
        // 1. $this->getPostTitle();
        $funcName = 'get' . \str_replace('_', '', \ucwords($name, '_'));
        if (\method_exists($this, $funcName)) {
            $this->data[$name] = $this->{$funcName}();
            return $this->data[$name];
        }
        // 2.1. apply_filters('vaf_wp_framework/post_type_ext/post/post_title')
        // 2.2. apply_filters('vaf_wp_framework/post_type_ext/all/post_title')
        $fieldName = $name;
        $params = [];
        if (\str_contains($fieldName, '__')) {
            $params = \explode('__', $fieldName);
            $fieldName = \array_shift($params);
        }
        $hookNameAll = 'vaf_wp_framework/post_type_ext/all/' . $fieldName;
        $hookNamePostType = 'vaf_wp_framework/post_type_ext/' . $this->getPost()->post_type . '/' . $fieldName;
        if (has_filter($hookNamePostType)) {
            $this->data[$name] = apply_filters($hookNamePostType, null, $this, $params);
            return $this->data[$name];
        }
        if (has_filter($hookNameAll)) {
            $this->data[$name] = apply_filters($hookNameAll, null, $this, $params);
            return $this->data[$name];
        }
        // 3. $this->post->post_title
        if (\property_exists($this->getPost(), $name)) {
            $this->data[$name] = $this->getPost()->{$name};
            return $this->data[$name];
        }
        // 4. $this->getMetaData('post_title')
        $this->data[$name] = $this->getMetadata($name);
        return $this->data[$name];
    }
    public function __isset(string $name) : bool
    {
        $val = $this->get($name);
        return !empty($val);
    }
    public function __get(string $name) : mixed
    {
        return $this->get($name);
    }
    public function getPostType() : string
    {
        return $this->getPost()->post_type;
    }
    public function getId() : int
    {
        return $this->getPost()->ID;
    }
}
