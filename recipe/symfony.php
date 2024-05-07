<?php

namespace Deployer;

require_once 'recipe/symfony.php';
require_once __DIR__ . '/common.php';

// Shared files that need to persist between deployments
set('shared_files', [
    '.env.local'
]);

// Shared directories that need to persist between deployments
set('shared_dirs', [
    'storage',
    'var/log'
]);

// Writable directories
set('writable_dirs', [
    'var',
    'var/cache',
    'var/log',
]);

// Deployment and HTTP users
set('remote_user', 'deploy');
set('http_user', 'apache');

// Web root
set('webroot', 'public');

// Deployment tasks
desc('deploy');
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'deploy:cache:clear',
    'deploy:publish',
]);
