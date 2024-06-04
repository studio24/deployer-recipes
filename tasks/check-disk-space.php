<?php

/**
 * Check disk space
 *
 * Inspired by Spatie Larvel-Health
 * @see https://spatie.be/docs/laravel-health/v1/available-checks/used-disk-space
 */

namespace Deployer;

use Deployer\Task\Context;

desc('Check remote server disk usage');
task('check:disk-space', function () {
    $filesystem = get('disk_space_filesystem', '');
    $threshold = (int) get('disk_space_threshold', 80);
    $max = (int) get('disk_space_max', 97);

    if (!empty($filesystem)) {
        // Run for a specific filesystem volume
        $output = run(sprintf("df -kh %s", $filesystem), timeout: 30);
    } else {
        // Or just run it and exclude temp volumes
        $output = run("df -kh -x tmpfs -x devtmpfs", timeout: 30);
    }
    if (preg_match_all('/(\d+)%/', $output, $m, PREG_PATTERN_ORDER)) {
        // One filesystem volume returned
        if (count($m[1]) === 1) {
            $used = $m[1][0];
            if ($used >= $max) {
                throw new \Exception(sprintf('Server disk space is too full to deploy to (%d%% used)', $used));
            } elseif ($used >= $threshold) {
                writeln(sprintf("<comment>Server disk space is almost full: %d%% used</comment>", $used));
            } else {
                writeln(sprintf("<info>Server disk space is OK: %d%% used</info>", $used));
            }
        }
    }
    writeln($output);
});
