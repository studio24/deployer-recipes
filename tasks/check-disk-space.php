<?php

namespace Deployer;

use Deployer\Task\Context;

/**
 * Inspired by Spatie Larvel-Health
 * @see https://spatie.be/docs/laravel-health/v1/available-checks/used-disk-space
 */
desc('Display server disk usage prior to deployment');
task('check:disk-space', function () {
    $filesystem = get('', '');
    $threshold = (int) get('disk_space_threshold', 80);

    if (!empty($filesystem)) {
        $output = run(sprintf("df -kh %s", $filesystem), timeout: 30);
    } else {
        $output = run("df -kh -x tmpfs -x devtmpfs", timeout: 30);
    }
    if (preg_match_all('/(\d+)%/', $output, $m, PREG_PATTERN_ORDER)) {

        // One filesystem volume returned
        if (count($m[1]) === 1) {
            $used = $m[1][0];
            if ($used > $threshold) {
                writeln(sprintf("<error>Server disk space is almost full: %d%% used</error>", $used));
            } else {
                writeln(sprintf("<info>Server disk space is OK: %d%% used</info>", $used));
            }
        }
    }
    writeln($output);
});
