<?php

namespace Deployer;

require_once 'recipe/common.php';
require_once __DIR__ . '/common.php';

desc('Prepares a new release');
task('deploy:prepare', [
    'deploy:info',
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'deploy:local_build',
    'deploy:rsync',
    'deploy:shared',
    'deploy:writable',
]);

desc('Publishes the release');
task('deploy:publish', [
    'deploy:symlink',
    'deploy:unlock',
    'deploy:cleanup',
    'deploy:success',
]);

// Deployment tasks
desc('Deploys your project');
task('deploy', [
    'deploy:prepare',
    'deploy:publish',
]);

/**
 * Run commands to build website locally
 *
 * Checks out Git repo, runs build commands
 *
 * Configuration
 * build_root: root directory to store build files (default is ~/.deployer)
 * build_folder: directory that contains built website files
 * build_commands: array of build commands to run on build files
 */
desc('Build website locally');
task('deploy:local_build', function () {

    $git = get('bin/git');
    $target = get('target');

    $targetWithDir = $target;
    if (!empty(get('sub_directory'))) {
        $targetWithDir .= ':{{sub_directory}}';
    }

    //  Set project root directory for build
    $buildPath = get('build_root', getenv('HOME') . '/.deployer');
    $buildFolder = get('build_folder');

    // @see https://deployer.org/docs/7.x/recipe/deploy/info
    $repo = get('what');
    $buildPath = $buildPath . '/' . $repo;
    set('build_path', $buildPath);

    //  Create local build directory
    if (!file_exists($buildPath)) {
        writeln('Creating build directory');
        mkdir($buildPath, recursive: true);
    }

    //  Remove previous local build
    $files = (int) runLocally(sprintf('ls %s | wc -l', $buildPath));
    if ($files > 0) {
        run(sprintf('rm -rf %s/*', $buildPath));
        writeln('Removed previous build');
    }

    // Checkout build
    writeln('Cloning repository (Branch: <info>{{branch}}</info>)');

    //  Clone the required branch to the local build directory
    runLocally("$git archive $targetWithDir | tar -x -f - -C $buildPath 2>&1");
    writeln('Clone complete');

    // Save git revision
    set('revision', runLocally("$git rev-list $target -1"));

    // Run build commands
    writeln('Run build commands...');
    cd($buildPath);
    invoke('local_build');

    writeln('Build complete.');
});

task('local_build', function() {
    writeln('Override this task in your deploy.php file');
});

/**
 * Upload website build files to remote server
 *
 * Configuration
 * build_folder: directory that contains built website files (optional)
 * rsync_folder: directory to rsync files to, relative to release_path (optional)
 */
desc('Sync website build files to remote');
task("deploy:rsync", function() {

    // Ensure build path has trailing slash
    $buildPath = rtrim(get('build_path'), '/') . '/' . trim(get('build_folder'), '/') . '/';
    if (empty($buildPath) || !is_dir($buildPath)) {
        error('Source folder cannot be determined via build_path or build_folder! Please add the folder where your website files are built to via set("build_folder", "path")');
    }

    // Destination path to rsync files to
    $rsyncFolder = ltrim(get('rsync_folder'), '/');
    if (!empty($rsyncFolder)) {
        $rsyncFolder = '/' . $rsyncFolder;
        set('webroot', $rsyncFolder);
    } else {
        // Save _build_summary.json to current directory if rsync_folder not set
        set('webroot', './');
    }

    // Rsync
    writeln("Rsync build files to server from $buildPath to {{release_path}}");
    upload($buildPath, "{{release_path}}$rsyncFolder", ["progress_bar" => true]);
    writeln('Rsync complete.');

    // Save git revision in REVISION file
    $rev = get('revision');
    run("echo $rev > {{release_path}}/REVISION");
});


/**
 * Run NPM commands locally using NVM
 *
 * @param string $command
 * @param bool $nvm Whether to run via NVM, Node Version Manager
 * @return string
 * @throws Exception\RunException
 */
function runNpmLocally(string $command, bool $nvm = true)
{
    if ($nvm) {
        $command = sprintf("source ~/.nvm/nvm.sh && nvm use && %s", $command);
    }
    return runLocally($command);
}