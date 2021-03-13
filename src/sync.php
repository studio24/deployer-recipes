<?php

namespace Deployer;

use Deployer\Task\Context;
use Symfony\Component\Console\Input\InputOption;

option('files', null, InputOption::VALUE_OPTIONAL, 'Files to sync from remote to local');

desc('Download files from staging or production to local development');
task('sync', function () {
    $files = [];
    if (input()->hasOption('files')) {
        $files = input()->getOption('files');
    }

    /** @var array $sync name => [ remote => local ]*/
    $sync = get('sync');

    // Select first download files option, if name not set as an option
    if (empty($files)) {
        $files = key($sync);
    }

    if (!isset($sync[$files])) {
        writeLn(sprintf("<error>File name '%s' not found in config setting 'sync', exiting!</error>", $files));
        return;
    }
    $remote = key($sync[$files]);
    $local = current($sync[$files]);
    $remote = ltrim($remote, '/');
    $local = ltrim($local, '/');

    // Increased timeout to overwrite default PHP limit of 300 seconds
    set('default_timeout', 1200);

    /**
     * @see https://github.com/deployphp/deployer/blob/v6.8.0/src/Task/Context.php
     */
    $host = Context::get()->getHost();

    $command = "rsync -avh {$host}:{{deploy_path}}/{$remote} {$local}";

    writeln(' ');
    if (preg_match('/\/$/', $remote)) {
        writeln("<info>Downloading folder from $remote ({{stage}}) to $local (local dev)</info>");
    } else {
        writeln("<info>Downloading file from $remote ({{stage}}) to $local (local dev)</info>");
    }
    if (isVerbose()) {
        writeln('<info>Rsync command: ' . $command . '</info>');
    }
    writeln(' ');

    if (!askConfirmation('Continue with rsync operation?')) {
        die('Ok, rsync cancelled.');
    }
    output()->write(runLocally($command));
});
