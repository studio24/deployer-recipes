<?php

namespace Deployer;

require_once 'recipe/common.php';
require_once __DIR__ . '/common.php';

// Save _build_summary.json to current directory for static deployments
set('webroot', './');

desc('Prepares a new release');
task('deploy:prepare', [
    'deploy:info',
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'deploy:build_local',
    'deploy:rsync_code',
    'deploy:shared',
    'deploy:writable',
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
 * build_root: root directory to store build files
 * build_commands: array of build commands to run on build files
 */
desc('Build website locally');
task('deploy:build_local', function () {

    //  Set project root directory for build
    $buildPath = get('build_root', getenv('HOME') . '/.deployer');

    // @see https://deployer.org/docs/7.x/recipe/deploy/info
    $repo = get('what');
    $buildPath = $buildPath . '/' . $repo;

    //  Create local build directory
    if (!file_exists($buildPath)) {
        writeln('Creating build directory');
        mkdir($buildPath, recursive: true);
    }

    //  Remove previous local build
    $files = (int) runLocally(sprintf('ls %s | wc -l'));
    if ($files > 0) {
        run(sprintf('rm -rf %s/*', $buildPath));
        writeln('Removed previous build');
    }

    // Checkout build
    writeln('Cloning repository (Branch: <info>{{branch}}</info>)');

    //  Clone the required branch to the local build directory
    runLocally(sprintf("git archive {{branch}} | tar -x -f - -C %s 2>&1", $buildPath));
    writeln('Clone complete');

    cd($buildPath);

    // Run build commands
    $buildCommands = get("build_commands", []);
    if (empty($buildCommands)) {
        error('No build commands set, quitting! Please add an array of build commands via set("build_commands", ["command1", "command2"])');
    }
    if (!is_array($buildCommands)) {
        $buildCommands = [$buildCommands];
    }

    writeln('Run build commands...');
    foreach ($buildCommands as $command) {
        runLocally('composer install');
    }

    writeln('Build complete.');
});

/**
 * Upload website build files to remote server
 *
 * Configuration
 * build_folder: directory to rsync to the remote server the contains the built website files
 * remote_folder: directory to rsync the built websites files to on the remote server (optional, if not set = current folder)
 */
desc('Sync website build files to remote');
task("deploy:rsync_code", function() {

    $buildFolder = get('build_folder');
    if (empty($buildFolder) || !file_exists($buildFolder)) {
        error('No source folder set! Please add the folder where your website files are built to via set("build_dist", "folder_path")');
    }
    $destination = get("remote_folder", "./");

    // Set web root to the build_dist so the build summary task runs
    set('webroot', $buildFolder);

    // Rsync
    writeln('Rsync build files to server...');
    upload($buildFolder, $destination, ["progress_bar" => true]);
    writeln('Rsync complete.');
});
