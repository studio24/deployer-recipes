<?php
namespace Deployer;

/**
 * Deployer recipes we are using for this website
 */
require 'recipe/common.php';
require 'vendor/studio24/deployer-recipes/common.php';

/**
 * Deployment configuration variables - set on a per-project basis
 */

// Friendly project name
set('application', 'Our Test Website');

// The repo for the project
set('repository', 'git@github.com:studio24/xxx.git');

// Shared files that are not in git and need to persist between deployments (e.g. local config)
set('shared_files', [
    'config/wp-config.local.php'
]);

// Shared directories that are not in git and need to persist between deployments (e.g. uploaded images)
set('shared_dirs', [
    'web/wp-content/uploads',
    '.well-known',
    'web/wp-content/cache',
    'var/log'
]);

// Sets directories as writable (e.g. uploaded images)
set('writable_dirs', [
    'web/wp-content/uploads',
    'web/wp-content/cache'
]);

// Array of remote => local file locations to sync to your local development computer
$sync = [
    'images' => [
        'shared/web/wp-content/uploads/' => 'web/wp-content/uploads'
    ],
    'weblogs' => [
        'data/logs/' => 'logs',
    ]
];


// Web root
set('webroot', 'web');

/**
 * Apply configuration to Deployer
 *
 * Don't edit beneath here unless you know what you're doing!
 *
 * DO NOT store the Slack hook in a public repo
 */


set('application', $project_name);
set('repository', $repository);
set('shared_files', $shared_files);
set('shared_dirs', $shared_directories);
set('writable_dirs', $writable_directories);
set('sync', $sync);
set('http_user', 'apache');
set('webroot', 'web');
set('slack_webhook', 'https://hooks.slack.com/services/XXXXX/XXXXX/xxxxxx');
set('keep_releases', 10);

// Default stage - prevents accidental deploying to production with dep deploy
set('default_stage', 'staging');

/**
 * Hosts
 */

host('production')
    ->stage('production')
    ->user('deploy')
    ->hostname('123.456.789.10')
    ->set('deploy_path', '/data/var/www/vhosts/our-site/production')
    ->set('url', 'https://www.our-website.com');

host('staging')
    ->stage('staging')
    ->user('deploy')
    ->hostname('123.456.789.10')
    ->set('deploy_path', '/data/var/www/vhosts/our-site/staging')
    ->set('url', 'https://staging.our-website.com');


/**
 * Deployment task
 * The task that will be run when using dep deploy
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
