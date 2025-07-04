<?php

namespace Deployer;

require_once 'recipe/common.php';
require_once __DIR__ . '/common.php';

// Path to WordPress core
set('wordpress_path', 'web/wordpress');

// Shared files that need to persist between deployments
set('shared_files', [
    'config/wp-config.local.php'
]);

// Shared directories that need to persist between deployments
set('shared_dirs', [
    '.well-known',
    'web/content/uploads',
    'web/content/cache',
    '{{wordpress_path}}',
]);

// Writable directories
set('writable_dirs', [
    'web/content/uploads',
    'web/content/cache',
    '{{wordpress_path}}',
]);

// Deployment and HTTP users
set('remote_user', 'deploy');
set('http_user', 'apache');

// Web root
set('webroot', 'web');

// Array of remote => local file locations to sync to your local dev environment
set('sync', [
    'images' => [
        'shared/web/content/uploads/' => 'web/content/uploads'
    ],
]);

// Install WordPress
task('deploy:wordpress_install', function() {
    $wordPressPath = get('wordpress_path', false);

    cd('{{release_path}}');
    run(sprintf('mkdir -p %s', $wordPressPath));
    $stage = get('stage');

    // Install WP if not already installed
    if (!testWp('core is-installed --path=%s 2>/dev/null', $wordPressPath)) {
        // @see https://developer.wordpress.org/cli/commands/core/download/
        wp(sprintf('core download --skip-content --path=%s', $wordPressPath), $stage);
        writeln('Downloaded WordPress version: ');
    } else {
        writeln('Skipping WordPress download, current installed version: ');
    }
    wp(sprintf('core version --path=%s', $wordPressPath), $stage);
});

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

function testWp(string $command, ?string $stage = null)
{
    if (null === $stage) {
        $stage = get('stage', 'production');
    }
    return test(sprintf('WP_ENV=%s wp %s', $stage, $command));
}

// Deployment tasks
desc('Deploys your project');
task('deploy', [
    'deploy:prepare',
    'deploy:wordpress_install',
    'deploy:publish',
]);

// Test if root Composer file exists
if (file_exists('./composer.json')) {
    after('deploy:prepare', 'deploy:vendors');
}
