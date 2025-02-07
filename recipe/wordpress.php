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

// WordPress core folder
set('wordpress_core_folder', 'web/wordpress/');

// Download WordPress Core files
task('deploy:download_wordpress', function() {
    $path = "{{release_path}}/{{wordpress_core_folder}}";

    // @see https://developer.wordpress.org/cli/commands/core/download/
    wp('core download --skip-content --path=' . $path);

    writeln('Downloaded WordPress version:');
    wp('core version');
});
after('deploy:update_code', 'deploy:download_wordpress');

/**
 * Run WP CLI
 *
 * @param string $command wp command, e.g. core download
 * @param ?string $stage environment, e.g. production. Defaults to the current stage name
 * @return void
 * @throws Exception\Exception
 * @throws Exception\RunException
 * @throws Exception\TimeoutException
 */
function wp(string $command, ?string $stage = null)
{
    if (null === $stage) {
        $stage = get('stage', 'production');
    }
    run(sprintf('WP_ENV=%s wp %s', $stage, $command), real_time_output: true);
}
