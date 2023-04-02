<?php

namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

option('files', null, InputOption::VALUE_OPTIONAL, 'Files to sync from remote to local');
option('dry-run', null, InputOption::VALUE_NONE, 'Run rsync in dry-run mode');

desc('Download files from a remote server to your local development environment');
task('sync', function () {

    // Dry-run?
    $dryRun = false;
    if (input()->hasOption('dry-run')) {
        $dryRun = input()->getOption('dry-run');
        writeln("<info>Dry-run mode</info>");
    }

    // What files do we want to sync?
    $files = [];
    if (input()->hasOption('files')) {
        $files = input()->getOption('files');
    }

    /** @var array $sync name => [ remote => local ] */
    $sync = get('sync');

    // Select first files option, if name not set as an option
    if (empty($files)) {
        $files = key($sync);
    }

    if (!isset($sync[$files])) {
        writeLn(sprintf("<error>File name '%s' not found in config setting 'sync', exiting!</error>", $files));
        return;
    }
    $remote = key($sync[$files]);
    $local = current($sync[$files]);

    // Increased timeout to overwrite default PHP limit of 300 seconds
    set('default_timeout', 1200);

    $user = currentHost()->getRemoteUser();
    $host = currentHost()->getHostname();
    $deployPath = rtrim(get('deploy_path'), '/');
    $remote = ltrim($remote, '/');
    $local = ltrim($local, '/');

    if (!$dryRun) {
        $command = "rsync -av {$user}@{$host}:{$deployPath}/{$remote} {$local}";
    } else {
        $command = "rsync -av --dry-run {$user}@{$host}:{$deployPath}/{$remote} {$local}";
    }

    writeln(' ');
    if (preg_match('/\/$/', $remote)) {
        writeln("<info>Downloading folder from $remote ({{alias}}) to $local (local dev)</info>");
    } else {
        writeln("<info>Downloading file from $remote ({{alias}}) to $local (local dev)</info>");
    }
    if (output()->isVerbose()) {
        writeln('<info>Rsync command: ' . $command . '</info>');
    }
    writeln(' ');

    if (!askConfirmation('Continue with sync operation?')) {
        warning('OK, sync cancelled.');
        return;
    }

    output()->write(runLocally($command));

    writeln(' ');
    writeln("<info>Files successfully synched to $local (local dev)</info>");
});
