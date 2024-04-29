<?php

namespace Deployer;

use Symfony\Component\Console\Question\ChoiceQuestion;

desc('View log files');
task('log-files', function () {

    if (!has('log_files')) {
        warning("Please, specify \"log_files\" option.");
        return;
    }
    $logFiles = get('log_files');
    if (!is_array($logFiles)) {
        $logFiles = explode(' ', $logFiles);
    }



    // Default functionality
    if (is_array($logFiles)) {
        $logFiles = implode(' ', $logFiles);
    }
    cd('{{current_path}}');
    run(sprintf('tail -f %s', $logFiles));

})->verbose();
