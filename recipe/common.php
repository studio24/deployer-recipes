<?php

namespace Deployer;

// Require all Studio 24 Deployer tasks
require_once __DIR__ . '/../tasks/sync.php';
require_once __DIR__ . '/../tasks/build-summary.php';
require_once __DIR__ . '/../tasks/show-summary.php';
require_once __DIR__ . '/../tasks/check-branch.php';
require_once __DIR__ . '/../tasks/confirm-continue.php';
require_once __DIR__ . '/../tasks/display-disk-space.php';
require_once __DIR__ . '/../tasks/vendors-subpath.php';

// Run pre-deployment checks
task('pre-deploy-checks', [
    'check-branch',
    'show-summary',
    'display-disk-space',
    'confirm-continue',
]);

before('deploy', 'pre-deploy-checks');

// Update build summary after deployment
before('deploy:publish', 'build-summary');

// Add unlock to failed deployment event.
after('deploy:failed', 'deploy:unlock');

// Do not track - telemetry
putenv('DO_NOT_TRACK=1');
