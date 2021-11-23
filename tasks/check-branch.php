<?php

namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

option('force', null, InputOption::VALUE_NONE, 'Forces deployment of a not main branch to production.', null);

desc('Check the branch to ensure only main/master is deployed to production');
task('s24:check-branch', function () {
    $stage = get('hostname');
    $branch = get('branch');
    $default_branch = runlocally("LANG=C git remote show {{repository}} | grep 'HEAD branch' | cut -d' ' -f5");



    $force_deploy = null;
    if (!empty(input()->hasOption('force'))) {
        $force_deploy = input()->getOption('force');
    }

    if ($stage == 'production' && $branch != $default_branch) {
        if ($force_deploy == true) {
            writeln("<fg=blue;options=bold>Forcing deployment of <fg=red;options=bold>$branch</> <fg=blue;options=bold>to $stage.</>");
        } else {
            writeln("<fg=blue;options=bold>You cannot deploy </><fg=red;options=bold>$branch </> <fg=blue;options=bold>to </><fg=yellow;options=bold>$stage</>");
            throw new \RuntimeException("Deployment abandoned");
        }
    } else {
        writeln(" ");
        writeln("<fg=green;options=bold>The $branch branch is OK to deploy to $stage</>");
        writeln("<fg=blue;options=bold>Continuing with deployment</>");
    }
});
