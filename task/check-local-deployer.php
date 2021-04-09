<?php

namespace Deployer;

use Studio24\Deployer\Check;

desc('Check currently used deployer path');
task('s24:check-local-deployer', function () {

    if (!Check::isLocalDeployer()) {
        writeln("");
        writeln("<comment>Please run using local Deployer with ./vendor/bin/dep</>");
        writeln("");

        if (!askConfirmation('Continue with deployment?')) {
            die('Ok, deployment cancelled.');
        }
    }
});
