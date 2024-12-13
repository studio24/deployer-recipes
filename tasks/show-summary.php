<?php

namespace Deployer;

use Deployer\Exception\HttpieException;
use Deployer\Utility\Httpie;

desc('Display the build_summary from the webserver');
task('show', function () {

    $current = get('current_path');
    $buildSummaryPath = rtrim($current, '/') . '/' . trim(get('webroot'), '/') . '/_build_summary.json';
    $destination = tempnam(sys_get_temp_dir(), '_build_summary');

    // Get current build summary, skip this if it doesn't exist
    if (!test("[ -f $buildSummaryPath ]")) {
        warning(sprintf('Build summary file does not exist at path: %s', $buildSummaryPath));
        return;
    }

    // Download _build_summary.json
    download($buildSummaryPath, $destination, ['progress_bar' => false]);
    $data = file_get_contents($destination);
    unlink($destination);

    // Try to decode JSON data
    try {
        $json = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
    } catch (\JsonException $e) {
        warning(sprintf('Cannot decode JSON data in file: %s, error: %s', $buildSummaryPath, $e->getMessage()));
        return;
    }
    if (empty($json)) {
        warning(sprintf('No valid JSON data found in file: %s', $buildSummaryPath));
        return;
    }

    /**
     * Get build summary data, support old and new variable names
     */
    $normalise = [
        'environment' => ['environment'],
        'deploy_datetime' => ['deploy_datetime', 'buildDateTime'],
        'git_branch' => ['git_branch', 'gitBranch'],
        'git_commit' => ['git_commit', 'commitId'],
        'deployed_by' => ['deployed_by', 'deployedBy'],
    ];
    $buildData = [];
    foreach ($normalise as $property => $values) {
        foreach ($values as $value) {
            if (isset($json[$value])) {
                $buildData[$property] = $json[$value];
            }
        }
        if (!isset($buildData[$property])) {
            warning(sprintf('No valid build summary data found in file: %s', $buildSummaryPath));
            return;
        }
    }

    // Get git repo link
    if (preg_match('/^(.+)@(.+):(.+)\.git$/i', get('repository'), $m)) {
        $gitHost = $m[2];
        $gitRepo = $m[3];

        switch ($gitHost) {
            case 'github.com':
                $buildData['git_commit_url'] = 'https://github.com/' . $gitRepo . '/commit/' .  $buildData['git_commit'];
                break;
            case 'bitbucket.org':
                $buildData['git_commit_url'] = 'https://bitbucket.org/' . $gitRepo . '/commit/' .  $buildData['git_commit'];
                break;
            case 'gitlab.org':
                $buildData['git_commit_url'] = 'https://gitlab.com/' . $gitRepo . '/-/commit/' . $buildData['git_commit'];
                break;
        }
    }

    // Output last build info
    try {
        $date = new \DateTimeImmutable($buildData['deploy_datetime']);
    } catch (\Exception $e) {
        // Try old legacy format "20240415_094357"
        $date = \DateTimeImmutable::createFromFormat('Ymd_His', $buildData['deploy_datetime']);
    }
    $summary = sprintf(
        '<options=bold>Last build:</> <info>%s</> deployed <info>%s</> branch to <info>%s</> environment on <info>%s</>',
        $buildData['deployed_by'],
        $buildData['git_branch'],
        $buildData['environment'],
        $date->format('r')
    );

    info($summary);
    if (isset($buildData['git_commit_url'])) {
        info('<options=bold>View git commit:</> ' . $buildData['git_commit_url']);
    }
});
