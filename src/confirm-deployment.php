<?php

namespace Deployer;

    task('deploy:s24:confirm', function() {
        if(!askConfirmation('Continue with deployment?')) {
        die('Ok, deployment cancelled.');
        }
        });
