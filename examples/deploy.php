<?php
namespace Deployer;

/**
 * 1. Deployer recipes we are using for this website
 */
require 'recipe/common.php';
require 'vendor/studio24/deployer-recipes/recipe/common.php';

/**
 * 2. Deployment configuration variables
 */

// Friendly project name
set('application', 'Our Test Website');

// The repo for the project
set('repository', 'git@github.com:studio24/xxx.git');

// Shared files that are not in git and need to persist between deployments (e.g. local .env file)
set('shared_files', [
    'config/wp-config.local.php'
]);

// Shared directories that are not in git and need to persist between deployments (e.g. uploaded images)
set('shared_dirs', [
    '.well-known',
    'web/wp-content/uploads',
    'web/wp-content/cache',
    'var/log'
]);

// Sets directories as writable (e.g. uploaded images)
set('writable_dirs', [
    'web/wp-content/uploads',
    'web/wp-content/cache'
]);

// Array of remote => local file locations to sync to your local development computer
set('sync', [
    'images' => [
        'shared/web/wp-content/uploads/' => 'web/wp-content/uploads'
    ],
    'weblogs' => [
        'data/logs/' => 'logs',
    ]
]);

// Web root
set('webroot', 'web');


/**
 * 3. Hosts
 */

host('production')
    ->set('hostname', '63.34.69.8')
    ->set('deploy_path', '/data/var/www/vhosts/studio24.net/production')
    ->set('log_files', '/data/logs/studio24.net.access.log /data/logs/studio24.net.error.log')
    ->set('url', 'https://www.studio24.net');

host('staging')
    ->set('hostname', '63.34.69.8')
    ->set('deploy_path', '/data/var/www/vhosts/studio24.net/staging')
    ->set('log_files', '/data/logs/staging.studio24.net.access.log /data/logs/staging.studio24.net.error.log')
    ->set('url', 'https://staging.studio24.net');


/**
 * 4. Deployment tasks
 *
 * Any custom deployment tasks to run
 */

runLocally('s24:check-local-deployer');

desc('Deploy ' . get('application'));
task('deploy', [

    // Check that we are using local deployer
    's24:check-local-deployer',

    // Run initial checks
    'deploy:info',
    's24:check-branch',
    's24:show-summary',
    's24:display-disk-space',

    // Request confirmation to continue (default N)
    's24:confirm-continue',

    // Deploy site
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',

    // Composer install
    'deploy:vendors',

    'deploy:shared',
    'deploy:writable',
    'deploy:clear_paths',
    's24:build-summary',

    // Build complete, deploy is live once deploy:symlink runs
    'deploy:symlink',

    // Cleanup
    'deploy:unlock',
    'cleanup',
    'success'
]);

// Slack notification on successful deploy to prod
after('success', 's24:notify-slack');

// Add unlock to failed deployment event.
after('deploy:failed', 'deploy:unlock');
