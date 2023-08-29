<?php

use VAF\WP\Framework\PHPScoperConfigGenerator;

$scoperConfigGen = new PHPScoperConfigGenerator(
    baseDir: __DIR__,
    prefix: '%%VENDOR_NAMESPACE%%',
    buildDir: './vendor_prefixed'
);

// Do not prefix ignored packages
//$scoperConfigGen->ignorePackage('myvendor/mypackage');

return $scoperConfigGen->buildConfig();
