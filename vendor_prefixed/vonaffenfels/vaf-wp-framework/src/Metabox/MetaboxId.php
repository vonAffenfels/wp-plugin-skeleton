<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Metabox;

/** @internal */
class MetaboxId
{
    private string $class;
    private string $methodName;
    public static function fromClassMethodName(string $class, string $methodName) : self
    {
        $metaboxId = new static();
        $metaboxId->class = $class;
        $metaboxId->methodName = $methodName;
        return $metaboxId;
    }
    public function __toString() : string
    {
        return \strtolower($this->classWithoutPath() . '_' . $this->methodName);
    }
    private function classWithoutPath() : string
    {
        $parts = \explode('\\', $this->class);
        return \end($parts);
    }
}
