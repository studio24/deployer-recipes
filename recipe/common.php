<?php

namespace Deployer;

// Require all Studio 24 Deployer tasks
use Studio24\DeployerRecipes\Command\LogsSearchCommand;

// Add custom deployment tasks
require_once __DIR__ . '/../tasks/sync.php';
require_once __DIR__ . '/../tasks/build-summary.php';
require_once __DIR__ . '/../tasks/show-summary.php';
require_once __DIR__ . '/../tasks/check-branch.php';
require_once __DIR__ . '/../tasks/check-disk-space.php';
require_once __DIR__ . '/../tasks/check-ssh.php';
require_once __DIR__ . '/../tasks/confirm-continue.php';
require_once __DIR__ . '/../tasks/vendors-subpath.php';
require_once __DIR__ . '/../tasks/logs.php';

// Default deployment and HTTP users
set('remote_user', 'deploy');
set('http_user', 'apache');

// Default web root
set('webroot', 'web');

// Run pre-deployment checks
desc('Run pre-deployment checks');
task('deploy:pre-deploy-checks', [
    'check:branch',
    'show',
    'check:disk-space',
    'confirm-continue',
])->hidden();
before('deploy', 'deploy:pre-deploy-checks');

// Update build summary after deployment
before('deploy:publish', 'build-summary');

// Add unlock to failed deployment event.
after('deploy:failed', 'deploy:unlock');

// Do not track - telemetry
putenv('DO_NOT_TRACK=1');

// @todo Backwards compatible, remove once merged into main branch
task('display-disk-space', ['check:disk-space'])->hidden();
task('check-branch', ['check:branch'])->hidden();
task('pre-deploy-checks', ['deploy:pre-deploy-checks'])->hidden();
task('show-summary', ['show-summary'])->hidden();
