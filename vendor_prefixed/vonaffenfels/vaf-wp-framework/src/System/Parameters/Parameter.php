<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\System\Parameters;

/** @internal */
class Parameter
{
    public function __construct(private readonly string $name, private readonly string $type, private readonly bool $isOptional, private readonly mixed $default, private readonly bool $isServiceParam, private readonly bool $isNullable)
    {
    }
    public function isNullable() : bool
    {
        return $this->isNullable;
    }
    public function isServiceParam() : bool
    {
        return $this->isServiceParam;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getNameLower() : string
    {
        return \strtolower($this->getName());
    }
    public function getType() : string
    {
        return $this->type;
    }
    public function isOptional() : bool
    {
        return $this->isOptional;
    }
    public function getDefault()
    {
        return $this->default;
    }
    public function toArray() : array
    {
        return ['name' => $this->getName(), 'type' => $this->getType(), 'isOptional' => $this->isOptional(), 'default' => $this->getDefault(), 'isServiceParam' => $this->isServiceParam(), 'isNullable' => $this->isNullable()];
    }
    public static function fromArray(array $data) : self
    {
        return new self(name: $data['name'], type: $data['type'], isOptional: $data['isOptional'], default: $data['default'], isServiceParam: $data['isServiceParam'], isNullable: $data['isNullable']);
    }
}
