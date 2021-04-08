<?php

namespace Deployer;

use Studio24\Deployer\Check;

desc('Check currently used deployer path');
task('s24:check-local-deployer', function () {

    $scriptPath = get_included_files()[0];

    if (strpos($scriptPath, '/vendor/deployer/deployer/bin/dep') === false) {
        writeln("");
        writeln("<comment>Please run using local Deployer with ./vendor/bin/dep</>");
        writeln("");
    }
    if (!askConfirmation('Continue with deployment?')) {
        die('Ok, deployment cancelled.');
    }
});
