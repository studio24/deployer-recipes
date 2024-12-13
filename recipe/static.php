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
 * build_folder: directory that contains built website files (optional)
 * build_commands: array of build commands to run on build files
 */
desc('Build website locally');
task('deploy:build_local', function () {

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
        writeln("Run: $command");
        echo runLocally($command);
    }

    // Save git revision in REVISION file
    $rev = runLocally("$git rev-list $target -1");
    if (!empty($buildFolder)) {
        $buildPath = rtrim($buildPath, '/') . '/' . ltrim($buildFolder, '/');
    }
    runLocally("echo $rev > $buildPath/REVISION");

    writeln('Build complete.');
});

/**
 * Upload website build files to remote server
 *
 * Configuration
 * build_folder: directory that contains built website files (optional)
 */
desc('Sync website build files to remote');
task("deploy:rsync_code", function() {

    // Ensure build path has trailing slash
    $buildPath = rtrim(get('build_path'), '/') . '/' . trim(get('build_folder'), '/') . '/';
    if (empty($buildPath) || !is_dir($buildPath)) {
        error('Source folder cannot be determined via build_path or build_folder! Please add the folder where your website files are built to via set("build_folder", "path")');
    }

    // Rsync
    writeln("Rsync build files to server from $buildPath to {{release_path}}");
    upload($buildPath, "{{release_path}}", ["progress_bar" => true]);
    writeln('Rsync complete.');
});
