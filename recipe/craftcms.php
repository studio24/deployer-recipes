<?php

namespace Deployer;

// require_once 'recipe/craftcms.php';
require_once __DIR__ . '/common.php';

// Shared files that are not in git and need to persist between deployments (e.g. local config)
set('shared_files', ['.env']);

// Shared directories that are not in git and need to persist between deployments (e.g. uploaded images)
set('shared_dirs', [
    'storage',
    'web/cpresources',
    'migrations',
]);

set('webroot', 'web');
set('git_ssh_command', 'ssh');

add('writable_dirs', [
    'config/project',
    'storage',
    'web/cpresources',
]);

// Custom Craft Tasks
desc('Backup DB prior to deployment');
task('craft:backup-db', function () {
        $path = get('deploy_path').'/current';

        writeln('Backing up Craft DB to db-backups');
        output()->write(run("cd $path && mkdir -p db-backups && php craft db/backup db-backups/"));
        writeln('DB backed up');

    }
);

desc('Restore DB after deployment failure');
task('craft:restore-db', function () {
    $path = get('deploy_path').'/current';
    $latest = run("cd $path && ls -t db-backups/ | head -n1");

    writeln('Restoring Craft DB from db-backups/' . $latest);
    output()->write(run("cd $path && php craft db/restore db-backups/$latest"));
    writeln('DB restored');

}
);


desc('Remind user to update remote .env before continuing');
task('env-reminder', function () {

    $stage = get('hostname');

    writeln(' ');
    writeln("<fg=green;options=bold>Please double check whether you need to edit the .env file on the server for $stage</>");
    writeln(' ');
    if (!askConfirmation('Continue with deployment?')) {
        die('Ok, deployment cancelled.');
    }
});

desc('Running Craft recommended deployment steps');
task('craft:deploy', function() {
    writeln('Running Craft deployment steps');
    writeln('Running Craft migrations');
    output()->write(run("php craft migrate/up --interactive=0"));
    output()->write(run("php craft migrate/all --no-content --interactive=0"));
    writeln('Applying Craft project config');
    output()->write(run("php craft project-config/apply"));
    writeln('Migrating Craft content');
    output()->write(run("php craft migrate --track=content --interactive=0"));
 });

 desc('Clear all Craft caches');
 task('craft:clear-cache', function () {
     $path = get('release_path');
 
     writeln('Running Craft clear-caches/all');
     output()->write(run("cd $path && php craft clear-caches/all"));
     writeln('Caches cleared');
 }
 );

// Deployment task

desc('deploy');
task('deploy', [
    'deploy:prepare',
    'env-reminder',
    'craft:backup-db',
    'deploy:vendors',
    'craft:deploy',
    'craft:clear-cache',
    'deploy:clear_paths',
    'deploy:publish'
]);

after('deploy:failed', 'deploy:unlock');
after('deploy:failed', 'craft:restore-db');