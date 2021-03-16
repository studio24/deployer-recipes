<?php

namespace Deployer;

desc('Ask confirmation from user before continuing with deployment');
    task('s24:confirm-continue', function () {
        if (!askConfirmation('Continue with deployment?')) {
            die('Ok, deployment cancelled.');
        }
    });
