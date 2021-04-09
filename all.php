<?php

// Require all Studio 24 Deployer task
require_once __DIR__ . '/tasks/sync.php';
require_once __DIR__ . '/tasks/build-summary.php';
require_once __DIR__ . '/tasks/show-summary.php';
require_once __DIR__ . '/tasks/check-branch.php';
require_once __DIR__ . '/tasks/confirm-continue.php';
require_once __DIR__ . '/tasks/display-disk-space.php';
require_once __DIR__ . '/tasks/vendors-subpath.php';
require_once __DIR__ . '/tasks/notify-slack.php';
require_once __DIR__ . '/tasks/check-local-deployer.php';
