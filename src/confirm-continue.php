<?php

namespace Deployer;

desc('Ask confirmation from user before continuing with deployment');
    task('s24:confirm', function() {
        if(!askConfirmation('Continue with deployment?')) {
        die('Ok, deployment cancelled.');
        }
        });
