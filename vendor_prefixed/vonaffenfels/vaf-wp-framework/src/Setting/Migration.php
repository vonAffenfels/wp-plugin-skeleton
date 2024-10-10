<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Setting;

use Closure;
/** @internal */
class Migration
{
    public function __construct(public readonly Closure $migrated, public readonly Closure $value, public readonly Closure $clear)
    {
    }
}
