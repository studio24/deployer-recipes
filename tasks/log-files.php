<?php

namespace Deployer;

use Symfony\Component\Console\Question\ChoiceQuestion;

desc('View log files');
task('logs:search', function () {

    if (!has('log_files')) {
        warning("Please, specify \"log_files\" option.");
        return;
    }
    $logFiles = get('log_files');
    if (!is_array($logFiles)) {
        $logFiles = explode(' ', $logFiles);
    }

    if (count($logFiles) > 1) {
        $logFile = askChoice("Choose a log file to view", $logFiles);
    } else {
        $logFile = $logFiles[0];
    }

    $search = ask("Enter search term (or leave blank to view last 25 lines and leave log open to view new entries)");

    if (empty($search)) {
        cd('{{current_path}}');
        run(sprintf('tail -n 25 -f %s', $logFile));
    } else {
        cd('{{current_path}}');
        run(sprintf('grep --color=always -i %s %s', $search, $logFile));
    }
})->verbose();
