<?php

namespace Deployer;

require_once 'recipe/craftcms.php';
require_once __DIR__ . '/common.php';

// Shared files that need to persist between deployments
set('shared_files', [
    '.env'
]);

// Shared directories that need to persist between deployments
set('shared_dirs', [
    'storage',
    'web/assets',
    'migrations',
]);

// Writable directories
set('writable_dirs', [
    'config/project',
    'storage',
    'web/assets',
    'web/cpresources',
]);

// Custom Craft Tasks
desc('Backup DB prior to deployment');
task('craft:backup-db', function () {
    writeln('Backing up Craft DB to storage/backups');
    craft('db/backup', ['showOutput' => true]);
});

desc('Restore DB after deployment failure');
task('craft:restore-db', function () {
    $latest = run("ls -t storage/backups/ | head -n1");
    writeln(sprintf('Restoring Craft DB from storage/backups/%s', $latest));
    craft(sprintf('db/restore storage/backups/%s', $latest), ['showOutput' => true]);
});

// @deprecated Not sure if this is still required
desc('Craft storage: reset storage permissions');
task('craft:storage', function () {
    writeln('Updating storage directory permissions');
    run('deploy:writable');
});

desc('Runs pending Craft CMS migrations and applies pending project config changes');
task('craft:up', craft('up --interactive=0'))->once();

// Deployment tasks
desc('Deploys your project');
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'craft:backup-db',
    'craft:up',
    'craft:clear-caches/all',
    'deploy:publish',
]);

after('deploy:failed', 'craft:restore-db');
