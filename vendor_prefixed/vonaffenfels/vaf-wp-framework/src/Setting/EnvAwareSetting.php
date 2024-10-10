<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Setting;

use WPPluginSkeleton_Vendor\VAF\WP\Framework\BaseWordpress;
/** @internal */
abstract class EnvAwareSetting extends Setting
{
    private mixed $envValue;
    public function __construct(string $name, BaseWordpress $base, mixed $default = null)
    {
        parent::__construct($name, $base, $default);
        $this->envValue = $this->parseEnv();
    }
    protected function get(?string $key = null)
    {
        if ($this->isFromEnv($key)) {
            return \is_null($key) ? $this->envValue : $this->envValue[$key] ?? $this->default[$key];
        }
        return parent::get($key);
    }
    public final function isFromEnv(?string $key = null) : bool
    {
        if (\is_null($this->envValue)) {
            return \false;
        }
        return \is_null($key) || !\is_null($this->envValue[$key] ?? null);
    }
    protected abstract function parseEnv();
}
