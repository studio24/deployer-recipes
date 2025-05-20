<?php

namespace Deployer;

require_once 'recipe/common.php';
require_once __DIR__ . '/common.php';

// Shared files that need to persist between deployments
set('shared_files', [
    'config/wp-config.local.php'
]);

// Shared directories that need to persist between deployments
set('shared_dirs', [
    '.well-known',
    'web/wp-content/uploads',
    'web/wp-content/cache',
]);

// Writable directories
set('writable_dirs', [
    'web/wp-content/uploads',
    'web/wp-content/cache'
]);

// Deployment and HTTP users
set('remote_user', 'deploy');
set('http_user', 'apache');

// Web root
set('webroot', 'web');

// Array of remote => local file locations to sync to your local dev environment
set('sync', [
    'images' => [
        'shared/web/wp-content/uploads/' => 'web/wp-content/uploads'
    ],
]);

// Install WordPress
task('deploy:wordpress_install', function() {
    $wordPressPath = get('wordpress_path', false);
    cd('{{release_path}}');
    run(sprintf('mkdir -p %s', $wordPressPath));
    $stage = get('stage');
    run(sprintf('WP_ENV=%s wp core download --skip-content --path=%s', $stage, $wordPressPath));
});

// Deployment tasks
desc('Deploys your project');
task('deploy', [
    'deploy:prepare',
    'deploy:publish',
]);

// Test if root Composer file exists
if (file_exists('./composer.json')) {
    after('deploy:prepare', 'deploy:vendors');
}
