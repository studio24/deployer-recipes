<?php

namespace Deployer;

use Deployer\Exception\Exception;
use Symfony\Component\Console\Input\InputOption;

option('force', null, InputOption::VALUE_NONE, 'Forces deployment of a not main branch to production.');

desc('Check the branch to ensure only main/master is deployed to production');
task('check:branch', function () {
    $alias = get('alias');
    $target = get('target');
    $defaultBranch = runLocally("git remote show {{repository}} | grep 'HEAD branch' | cut -d' ' -f5");

    $forceDeploy = false;
    if (!empty(input()->hasOption('force'))) {
        $forceDeploy = input()->getOption('force');
    }

    // If target = HEAD, set to the default branch (so we know what is deployed)
    if ($target === 'HEAD') {
        set('branch', $defaultBranch);
        set('target', $defaultBranch);
        $target = get('target');
        info(sprintf('Setting deployment branch to <fg=blue;options=bold>%s</>', $defaultBranch));
    }

    // Only allow default branch to be deployed to production, unless forced
    if ($alias === 'production' && $target !== $defaultBranch) {
        if ($forceDeploy === true) {
            warning("Forcing deployment of <options=bold>$target</> to <options=bold>$alias.</>");
            return;
        }

        throw error("You cannot deploy <options=bold>$target</> to <options=bold>$alias</>");
    }

    info("The $target branch is OK to deploy to $alias");
});
