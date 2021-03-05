<?php

namespace Deployer;

desc('Rsync assets from staging/production to development');
task('studio24:sync-down', function () {

    // @todo remove host_ip, use get('hostname') for current environment
    /*
     * @todo use array to define multiple sync commands
     * Usage: dep studio24:sync-down staging assets
     * @see https://deployer.org/docs/tasks.html#using-input-options

    // name of thing to sync: remote => local
    $syncDown = [
        'assets' => ['shared/web/wp-content/uploads' => 'web/wp-content/upload'],
        'log' => ...
    ];
    */

    $config = [
        'remote_shared' => get('remote_shared'),
        'host_ip' => get('host_ip'),
        'local_dir' => get('local_dir'),
    ];

    foreach ($config as $key => $value) {
        if (empty($value)) {
            throw new \RuntimeException(
                "Please set the configuration parameter $key");

        }
    }

    $config['remote_shared'] = rtrim($config['remote_shared'],'/') . '/';

    $command = "rsync -avh deploy@{$config['host_ip']}:{{deploy_path}}{$config['remote_shared']} {$config['local_dir']}";



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
