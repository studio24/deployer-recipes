<?php

namespace Deployer;

desc('Check currently used deployer path');
task('s24:check-local-deployer', function () {

    $scriptPath = get_included_files()[0];

    if (strpos($scriptPath, __DIR__.'/vendor/deployer/deployer/bin/dep') !== true) {
        throw new \RuntimeException("Pleaae run using local Deployer with ./vendor/bin/dep");
    }
});
