<?php
namespace Deployer;

/**
 * 1. Deployer recipes we are using for this website
 */
require_once 'vendor/studio24/deployer-recipes/recipe/static.php';

/**
 * 2. Deployment configuration variables
 */

// Project name
set('application', 'My Application Name');

// Git repo
set('repository', 'git@github.com:studio24/xxx.git');

// Filesystem volume we're deploying to
set('disk_space_filesystem', '/');

// Build commands for static site
set("build_commands", [
    "composer install",
    "./vendor/bin/design-system",
]);

// Directory that contains built website files
set("build_folder", "_dist");


/**
 * 3. Hosts
 */

host('production')
    ->set('hostname', '1.2.3.4')
    ->set('http_user', 'production')
    ->set('deploy_path', '/var/www/vhosts/DOMAIN.co.uk/production')
    ->set('log_files', [
        '/var/log/apache2/DOMAIN.co.uk.access.log',
        '/var/log/apache2/DOMAIN.co.uk.error.log',
    ])
    ->set('url', 'https://www.DOMAIN.co.uk');

host('staging')
    ->set('hostname', '1.2.3.4')
    ->set('http_user', 'staging')
    ->set('deploy_path', '/var/www/vhosts/DOMAIN.co.uk/staging')
    ->set('log_files', [
        '/var/log/apache2/staging.DOMAIN.co.uk.access.log',
        '/var/log/apache2/staging.DOMAIN.co.uk.error.log',
    ])
    ->set('url', 'https://DOMAIN.studio24.dev');
