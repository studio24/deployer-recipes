<?php

namespace Deployer;

desc('Rsync assets from staging/production to development');
task('s24:sync-down', function () {

    // Increased timeout to overwrite default PHP limit of 300 seconds
    set('default_timeout', 1200);

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
        'remote_assets' => get('remote_assets'),
        'local_assets' => get('local_assets'),
    ];

    foreach ($config as $key => $value) {
        if (empty($value)) {
            throw new \RuntimeException(
                "Please set the configuration parameter $key"
            );
        }
    }

    $config['remote_assets'] = rtrim($config['remote_assets'], '/') . '/';

    $command = "rsync -avh deploy@{{target}}:{{deploy_path}}{$config['remote_assets']} {$config['local_assets']}";



    writeln(' ');
    writeln("<fg=red;options=bold>Please make sure you are in the project root</>");
    writeln(' ');
    writeln("<info>Rsyncing files from {{stage}} to dev</info>");
    writeln(' ');
    writeln(' ');

    if (!askConfirmation('Continue with rsync?')) {
        die('Ok, rsync cancelled.');
    }
    output()->write(runLocally($command));
});
