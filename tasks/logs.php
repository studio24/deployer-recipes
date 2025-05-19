<?php

namespace Deployer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

option('logfile', null, InputOption::VALUE_OPTIONAL, 'Log file to display');
option('lines', null, InputOption::VALUE_OPTIONAL, 'How many lines of the logfile to display (use 0 to view all)');
option('search', null, InputOption::VALUE_OPTIONAL, 'Only return lines that match the search string');

// Backward compatibility
if (commandExist('logs:app')) {
    before('logs:app', function () {
        normaliseLogFilesSetting();
    });
}

desc('List available log files');
task('logs:list', function () {

    // Get array of log files
    if (!has('log_files')) {
        warning('Please specify "log_files" option in deploy.php to view log files.');
        return;
    }
    $logfiles = getLogFilesSettingAsArray();
    $logfiles = expandLogFiles($logfiles);

    writeln(sprintf('<info>Available log files on %s:</info>', currentHost()));
    foreach ($logfiles as $file) {
        writeln($file);
    }
});

desc('View a log file');
task('logs:view', function () {

    // Get array of log files
    if (!has('log_files')) {
        warning('Please specify "log_files" option in deploy.php to view log files.');
        return;
    }
    $logfiles = getLogFilesSettingAsArray();
    $logfiles = expandLogFiles($logfiles);

    // Select log file
    $logfile = getLogfileLogsOption($logfiles, 'view');

    $keepOpen = askConfirmation('Do you want to keep logfile open for new entries (yes/no)?');
    if ($keepOpen) {
        // Get terminal screen height
        $lines = (int) runLocally('tput lines');
        if ($lines < 10) {
            $lines = 20;
        }
    } else {
        // Set number of lines to display
        $lines = getLinesLogsOptions();
    }

    // View log file
    cd('{{current_path}}');
    if ($lines === 0) {
        run(sprintf('less %s', $logfile), real_time_output: true);
    } else {
        if ($keepOpen) {
            run(sprintf('tail -f -n %d %s', $lines, $logfile), real_time_output: true);
            return;
        } else {
            run(sprintf('tail -n %d %s', $lines, $logfile), real_time_output: true);
        }
    }

    // Build example command
    $command = sprintf('dep logs:view %s --logfile=%s --lines=%d', currentHost(), $logfile, $lines);
    writeln(sprintf('<info>Run again with: %s</info>', $command));
});

desc('Search a log file');
task('logs:search', function () {

    // Get array of log files
    if (!has('log_files')) {
        warning('Please specify "log_files" option in deploy.php to view log files.');
        return;
    }
    $logfiles = getLogFilesSettingAsArray();
    $logfiles = expandLogFiles($logfiles);

    // Select log file
    $logfile = getLogfileLogsOption($logfiles, 'search');

    // Search terms
    if (!empty(input()->getOption('search'))) {
        $search = input()->getOption('search');
    } else {
        $search = ask("Enter search term");
        while (empty($search)) {
            warning('Please specify a search term');
            $search = ask("Enter search term");
        }
    }

    // Set number of lines to display
    $lines = getLinesLogsOptions();

    // Search log file
    cd('{{current_path}}');
    if ($lines === 0) {
        run(sprintf('grep --color=always -i %s %s | less', $search, $logfile), real_time_output: true);
    } else {
        run(sprintf('grep --color=always -i %s %s | tail -n %d', $search, $logfile, $lines), real_time_output: true);
    }

    // Build example command
    $command = sprintf('dep logs:search %s --logfile=%s --lines=%d --search="%s"', currentHost(), $logfile, $lines, $search);
    writeln(sprintf('<info>Run again with: %s</info>', $command));
});

desc('Download a log file');
task('logs:download', function () {

    // Get array of log files
    if (!has('log_files')) {
        warning('Please specify "log_files" option in deploy.php to view log files.');
        return;
    }
    $logfiles = getLogFilesSettingAsArray();
    $logfiles = expandLogFiles($logfiles);

    // Select log file
    $logfile = getLogfileLogsOption($logfiles, 'download');

    // Destination
    $destination = ask('Enter destination path', './');

    // Download log file
    cd('{{current_path}}');
    download($logfile, $destination);
    writeln('Log file downloaded to: ' . $destination);

    // Build example command
    $command = sprintf('dep logs:download %s --logfile=%s', currentHost(), $logfile);
    writeln(sprintf('<info>Run again with: %s</info>', $command));
});

/**
 * Normalise log_files setting so it works with default Deployer tasks (that expect a string)
 * @return void
 */
function normaliseLogFilesSetting(): void
{
    if (!has('log_files')) {
        return;
    }
    $logfiles = get('log_files');
    if (is_array($logfiles)) {
        set('log_files', implode(' ', $logfiles));
    }
}

/**
 * Return log_files setting as an array so it works with these tasks
 * @return void
 */
function getLogFilesSettingAsArray(): array
{
    if (!has('log_files')) {
        return [];
    }
    $logfiles = get('log_files');
    if (!is_array($logfiles)) {
        $logfiles = explode(' ', $logfiles);
    }
    return $logfiles;
}

/**
 * Expand logfiles array to include any wildcard (*) files
 *
 * @param array $logfiles
 * @return array
 * @throws Exception\Exception
 * @throws Exception\RunException
 * @throws Exception\TimeoutException
 */
function expandLogFiles(array $logfiles): array
{
    foreach ($logfiles as $key => $file) {
        if (str_contains($file, '*')) {
            $path = dirname($file);
            $file = basename($file);
            cd('{{current_path}}');

            // Remove wildcard, so we can replace it with actual files
            unset($logfiles[$key]);

            // Test folder exists
            if (!test(sprintf('[ -d %s ]', $path))) {
                writeln('<error>Logs directory does not exist: ' . $path . '</error>');
                continue;
            }

            // Test files exist in folder
            $numFiles = run(sprintf('ls -A %s | wc -l', $path));
            if ($numFiles < 1) {
                writeln('<info>No logfiles exist in: ' . $path . '</info>');
                continue;
            }

            // Expand logfiles from wildcard
            cd($path);
            $output = run(sprintf('ls %s', $file));
            $files = explode("\n", $output);
            if (!empty($files)) {
                array_walk($files, function (&$value) use ($path) {
                    $value = $path . DIRECTORY_SEPARATOR . $value;
                });
                $logfiles = array_merge($logfiles, $files);
            }
        }
    }
    return $logfiles;
}

function getLogfileLogsOption(array $logfiles, string $action)
{
    if (!empty(input()->getOption('logfile'))) {
        return input()->getOption('logfile');
    } elseif (count($logfiles) > 1) {
        return askChoice('Choose a log file to ' . $action, $logfiles);
    } else {
        return $logfiles[0];
    }
}

function getLinesLogsOptions(): int
{
    if (!empty(input()->getOption('lines'))) {
        return (int) input()->getOption('lines');
    } else {
        return (int) ask("How many lines to display (0 to view all)", '20');
    }
}
