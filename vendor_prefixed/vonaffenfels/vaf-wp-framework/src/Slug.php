<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework;

/** @internal */
class Slug
{
    private string $name;
    public static function fromName(string $name) : self
    {
        $slug = new static();
        $slug->name = $name;
        return $slug;
    }
    public function __toString() : string
    {
        return \preg_replace('~[^a-zA-Z]+~', '-', \strtolower($this->name));
    }
}
