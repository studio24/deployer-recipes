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
require_once __DIR__ . '/tasks/notify-slack.php';
require_once __DIR__ . '/tasks/check-local-deployer.php';

// Set up defaults
set('remote_user', 'deploy');
set('http_user', 'apache');

// Make sure we are using Deployer installed via Composer
before('deploy', 's24:check-local-deployer');

// Only allow main branch to be deployed to production
after('s24:check-local-deployer', 's24:check-branch');

// Confirm what was last deployed
after('s24:check-branch', 's24:show-summary');

// Confirm current disk space
after('s24:show-summary', 's24:display-disk-space');

// Confirm you want to continue
after('s24:display-disk-space', 's24:confirm-continue');

// Update build summary after deployment
before('deploy:publish', 's24:build-summary');

// Add unlock to failed deployment event.
after('deploy:failed', 'deploy:unlock');