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
    'storage/backups',
    'storage/logs',
    'web/assets',
    'web/cpresources',
]);

// Custom Craft Tasks
desc('Output warning after deployment failure');
task('craft:fail-warning', function () {
    warning('The Craft deployment failed, please review DB backups (storage/backups) to assess whether you need to restore the database.');
});

// @deprecated Not sure if this is still required
desc('Craft storage: reset storage permissions');
task('craft:storage', function () {
    writeln('Updating storage directory permissions');
    invoke('deploy:writable');
});

desc('Runs pending Craft CMS migrations and applies pending project config changes');
task('craft:up', craft('up --interactive=0'))->once();

// Deployment tasks
desc('Deploys your project');
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'craft:up',
    'craft:clear-caches/all',
    'deploy:publish',
]);

after('deploy:failed', 'craft:fail-warning');
