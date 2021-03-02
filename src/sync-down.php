<?php

namespace Deployer;

desc('Rsync assets from staging/production to development');
task('studio24:sync-down', function () {
    $shared = get('remote_shared');
    $host = get('hostip');
    $local_dir = get('local_dir');
    $command = strval('rsync -avh deploy@'.$host.':{{deploy_path}}'.$shared.'/ '.$local_dir);
    $env = get('hostname');

    writeln(' ');
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
