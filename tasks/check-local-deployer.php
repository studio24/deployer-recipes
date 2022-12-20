<?php

namespace Deployer;

desc('Check currently used deployer path');
task('s24:check-local-deployer', function () {

    $includedFilePaths = get_included_files();

    if (strpos($includedFilePaths[0], '/vendor/deployer/deployer/bin/dep') !== false) {

        writeln("");
        writeln("<comment>Please run using local Deployer with ./vendor/bin/dep</>");
        writeln("");

        if (!askConfirmation('Continue with deployment?')) {
            die('Ok, deployment cancelled.');
        }

    }
});