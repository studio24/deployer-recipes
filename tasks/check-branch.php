<?php

namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

option('force', null, InputOption::VALUE_NONE, 'Forces deployment of a not main branch to production.', null);

desc('Check the branch to ensure only main/master is deployed to production');
task('s24:check-branch', function () {
    $alias = get('alias');
    $target = get('target');
    $defaultBranch = runLocally("git remote show {{repository}} | grep 'HEAD branch' | cut -d' ' -f5");

    $forceDeploy = false;
    if (!empty(input()->hasOption('force'))) {
        $forceDeploy = input()->getOption('force');
    }

    if ($alias === 'production' && $target !== $defaultBranch) {
        if ($forceDeploy === true) {
            writeln("<fg=blue;options=bold>Forcing deployment of <fg=red;options=bold>$target</> <fg=blue;options=bold>to $alias.</>");
        } else {
            writeln("<fg=blue;options=bold>You cannot deploy </><fg=red;options=bold>$target </> <fg=blue;options=bold>to </><fg=yellow;options=bold>$alias</>");
            invoke('deploy:failed');
            throw new \RuntimeException("Deployment abandoned");
        }
    } else {
        writeln(" ");
        writeln("<fg=green;options=bold>The $target branch is OK to deploy to $alias</>");
        writeln("<fg=blue;options=bold>Continuing with deployment</>");
    }
});

