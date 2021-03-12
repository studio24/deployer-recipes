<?php
namespace Deployer;

/*
 * Required to include all recipes from the Studio24
 * deployer-recipes repo.
 * View the README.md for information on including
 * individual recipes
 */
require 'vendor/studio24/deployer-recipes/all.php';

/*
 * Deployment Configuration variables
 * These are set on a per project basis
 */

// Friendly project name to help identify what is being deployed
$project_name = 'Our Test Website';

// The repo for the project
$repository = 'git@github.com:studio24/xxxxxxxxx.git';

// Production IP or CNAME
$production_server = '123.456.789.111';

// Staging IP or CNAME
$staging_server = 'ourwebhost.com';

// Path on the server for deployments
$project_path = '/data/var/www/vhosts/our-site';

// Staging URL
$staging_url = 'https://staging.our-website.com';

//Production URL
$production_url = 'https://www.our-website.com';

// Local assets directory relative to the project root
// Normally a git ignored directory
$local_assets = 'web/wp-content/uploads';

// Remote assets directory relative to the $project_path and stage
// Ths is normally a shared directory that is git ignored
$remote_assets = '/shared/web/wp-content/uploads';

// Shared files that contain sensitive data that needs to persist
// between deployments specific to the stage/host
$shared_files = [
    'config/wp-config.local.php'
];

// Shared directories that contain items that need to persist between
// deployments. Such as images and application log files.
$shared_directories = [
    'web/wp-content/uploads',
    '.well-known',
    'web/wp-content/cache',
    'var/log'
];

// Sets directories as writable by the web user eg: Apache
$writable_directories = [
    'web/wp-content/uploads',
    'web/wp-content/cache'
];

// Sample of code to be added
$sync_down = [
    'images' => [
        '{{server_host}}/path/images' => 'local/path/path/images'
    ]
];

// Default stage - prevents accidental deploying to production with dep deploy
set('default_stage', 'staging');

/*
 * Please do not change these unless you know what you're doing!
 */

// The 'public' directory used by Apache
$web_root = 'web';

// The remote user that deployed connects and uses to run commands
// on the server
$deploy_user = 'deploy';

// The remote user that runs the web service
$http_user = 'apache';

// This allow you to enter a passphrase for keys or add host to known_hosts.
$git_tty = true;

// The number of releases to keep on the server in
// case of the need to rollback
$keep_releases = 10;

/*
 * Apply Configuration
 * Sets the variables for use in the relevant recipes
 * and deployments
 */
set('application', $project_name);
set('repository', $repository);
set('git_tty', $git_tty);
set('http_user', $http_user);
set('shared_files', $shared_files);
set('shared_dirs', $shared_directories);
set('writable_dirs', $writable_directories);
set('keep_releases', $keep_releases);
set('allow_anonymous_stats', false);
set('host_ip', $server_host);
set('local_assets', $local_assets);
set('remote_assets', $remote_assets);


/*
 * Host information
 * These values are set with the variables above
 * and used in the deployed tasks and recipes
 */

host('production')
    ->stage('production')
    ->hostname($production_server)
    ->set('target', $production_server)
    ->set('webroot', $web_root)
    ->set('project_name', $project_name)
    ->user($deploy_user)
    ->set('url', $production_url)
    ->set('deploy_path', $project_path.'/production');

host('staging')
    ->stage('staging')
    ->hostname($staging_server)
    ->set('target', $staging_server)
    ->set('webroot', $web_root)
    ->set('project_name', $project_name)
    ->set('url', $staging_url)
    ->user($deploy_user)
    ->set('deploy_path', $project_path.'/staging');

host('staging2')
    ->stage('staging2')
    ->hostname($staging_server)
    ->set('webroot', $web_root)
    ->set('project_name', $project_name)
    ->user($deploy_user)
    ->set('deploy_path', $project_path.'/staging2');

/*
 * Deployment Task
 * The task that will be run when using
 * dep deploy stage eg:
 * dep deploy staging
 */

desc('Deploy '.$project_name);
task('deploy', [

    // Initialisation
    'deploy:info',

    // Checks if deploying a non default branch to production
    's24:check-branch',
    // Shows a summary of what is currently deployed
    's24:show-summary',
    // Display disk usage
    's24:display-disk-space',
    // Request confirmation to continue (default N)
    's24:confirm',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',

    // Git clone
    'deploy:update_code',
    // Installs the latest release of Wordpress core
    's24:wordpress-install,',
    // Created the remote build summary and displays the URL to it
    's24:build-summary',

    // Add custom tasks here.
    'deploy:shared',
    'deploy:writable',
    'deploy:clear_paths',

    // Build complete, not made live until deploy:symlink is run.
    'deploy:symlink',

    //'deploy:s24:slack_hook',
    'deploy:unlock',
    'cleanup',
    'success'
]);

/*
 * Custom Tasks
 */


// Send notification to Slack via simple curl request.
task('deploy:s24:slack_hook', function () {
    run('curl -X POST --data-urlencode "payload={\"text\": \"'.ucfirst(get('stage')).' deployment made to '.get('project_name').' ('.get('branch').')\", \"username\": \"deployments\", \"icon_emoji\": \":shipit:\"}" https://studio24.slack.com/services/hooks/incoming-webhook?token=24krXZGKSvP2s8jVTVp8UCwU');
});

// Add unlock to failed deployment event.
after('deploy:failed', 'deploy:unlock');
