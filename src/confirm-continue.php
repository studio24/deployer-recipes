<?php

namespace Deployer;

    task('s24:confirm', function() {
        if(!askConfirmation('Continue with deployment?')) {
        die('Ok, deployment cancelled.');
        }
        });
