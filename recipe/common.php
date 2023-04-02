<?php

namespace Deployer;

// Require all Studio 24 Deployer tasks
require_once __DIR__ . '/tasks/sync.php';
require_once __DIR__ . '/tasks/build-summary.php';
require_once __DIR__ . '/tasks/show-summary.php';
require_once __DIR__ . '/tasks/check-branch.php';
require_once __DIR__ . '/tasks/confirm-continue.php';
require_once __DIR__ . '/tasks/display-disk-space.php';
require_once __DIR__ . '/tasks/vendors-subpath.php';

// Set up defaults
set('remote_user', 'deploy');
set('http_user', 'apache');

// Run pre-deployment checks
task('s24:pre-deploy-checks', [
    's24:check-branch',
    's24:show-summary',
    's24:display-disk-space',
    's24:confirm-continue',
]);

before('deploy', 's24:pre-deploy-checks');

// Update build summary after deployment
before('deploy:publish', 's24:build-summary');

// Add unlock to failed deployment event.
after('deploy:failed', 'deploy:unlock');

// Do not track - telemetry
setenv('DO_NOT_TRACK=1');
