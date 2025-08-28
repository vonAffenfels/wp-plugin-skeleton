<?php

namespace WPPluginSkeleton_Vendor\VAF\WP\Framework\Assets;

/** @internal */
class AssetDependencies
{
    public readonly array $dependencies;
    public static function forFile($path) : self
    {
        $assetDependencies = new static();
        $loadAsset = function ($path) {
            $directory = \dirname($path);
            $matches = [];
            \preg_match('~(.*)(\\..*)~', \basename($path), $matches);
            $filenameWithoutExtension = $matches[1];
            return \file_exists("{$directory}/{$filenameWithoutExtension}.asset.php") ? require "{$directory}/{$filenameWithoutExtension}.asset.php" : [];
        };
        $assetDependencies->dependencies = $loadAsset($path)['dependencies'] ?? [];
        return $assetDependencies;
    }
}
