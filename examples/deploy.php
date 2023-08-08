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

// Set up default Deployment user and Apache user
set('remote_user', 'deploy');
set('http_user', 'apache');

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

// Install composer dependencies in subpaths
before('deploy:publish', 'vendors-subpath');

// Notify Slack on deployment
// @todo this doesn't appear to work
set('slack_channel', 'deployments');
before('deploy', 'slack:notify');
after('deploy:success', 'slack:notify:success');
