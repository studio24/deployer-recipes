<?php

namespace Deployer;

desc('Ask confirmation from user before continuing with deployment');
task('confirm-continue', function () {
    if (!askConfirmation('Continue with deployment?')) {
        throw error('Deployment aborted');
    }
});

