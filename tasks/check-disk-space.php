<?php

namespace Deployer;

use Deployer\Task\Context;

/**
 * Inspired by Spatie Larvel-Health
 * @see https://spatie.be/docs/laravel-health/v1/available-checks/used-disk-space
 */
desc('Display server disk usage prior to deployment');
task('check:disk-space', function () {

    $filesystem = get('disk_space_filesystem', '/data');
    $threshold = (int) get('disk_space_threshold', 80);

    $output = run(sprintf("df -kh %s", $filesystem), timeout: 30);
    if (preg_match('/(\d+)%/', $output, $m)) {
        $capacity = $m[1];

        if ($capacity > $threshold) {
            writeln(sprintf("<error>Less than %d%% disk space available on server</error>", (100 - $threshold)));
        } else {
            writeln("<info>Server disk space available: $capacity%</info>");
        }
    } else {
        writeln("<error>Unable to determine disk space on server</error>");
    }
    writeln($output);
});
