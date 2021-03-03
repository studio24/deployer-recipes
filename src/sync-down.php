<?php

namespace Deployer;

desc('Rsync assets from staging/production to development');
task('studio24:sync-down', function () {
    $config = [
        'shared' => get('remote_shared'),
        'host' => get('hostip'),
        'local_dir' => get('local_dir'),
    ];

    if (empty($config["shared"])) {
        throw new \RuntimeException(
            "Please set the remote shared directory");
    };
    if (empty($config["host"])) {
        throw new \RuntimeException(
            "Please set the remote IP address");
    };
    if (empty($config["local_dir"])) {
        throw new \RuntimeException(
            "Please set the local target directory");
    };


    $command = "rsync -avh deploy@{$config['host']}:{{deploy_path}}{$config['shared']}/ {$config['local_dir']}";



    writeln(' ');
    writeln("<fg=red;options=bold>Please make sure you are in the project root</>");
    writeln(' ');
    writeln("<info>Rsyncing files from {{stage}} to dev</info>");
    writeln(' ');
    writeln(' ');

    if(!askConfirmation('Continue with rsync?')) {
        die('Ok, rsync cancelled.');
    }
    output()->write(runLocally($command));

});
