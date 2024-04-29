<?php
namespace Deployer;

/**
 * 1. Deployer recipe we are using for this website
 */
require_once 'vendor/studio24/deployer-recipes/recipe/wordpress.php';


/**
 * 2. Deployment configuration variables
 */

// Project name
set('application', 'My Application Name');

// Git repo
set('repository', 'git@github.com:studio24/xxx.git');


/**
 * 3. Hosts
 */

host('production')
    ->set('hostname', '1.2.3.4')
    ->set('http_user', 'production')
    ->set('deploy_path', '/data/var/www/vhosts/DOMAIN.co.uk/production')
    ->set('log_files', '/data/logs/DOMAIN.co.uk.access.log /data/logs/DOMAIN.co.uk.error.log')
    ->set('url', 'https://www.DOMAIN.co.uk');

host('staging')
    ->set('hostname', '1.2.3.4')
    ->set('http_user', 'staging')
    ->set('deploy_path', '/data/var/www/vhosts/DOMAIN.co.uk/staging')
    ->set('log_files', '/data/logs/staging.DOMAIN.co.uk.access.log /data/logs/staging.DOMAIN.co.uk.error.log')
    ->set('url', 'https://DOMAIN.studio24.dev');


/**
 * 4. Deployment tasks
 *
 * Any custom deployment tasks to run
 */

// Install composer dependencies in subpaths
//before('deploy:publish', 'vendors-subpath');
