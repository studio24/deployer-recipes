<?php

namespace Deployer;

use Deployer\Exception\HttpieException;
use Deployer\Utility\Httpie;

desc('Display the build_summary from the webserver');
task('show', function () {

    // Get current build summary, skip this if it doesn't exist
    $buildUrl = rtrim(get('url'), '/') . '/_build_summary.json';
    try {
        $http = Httpie::get($buildUrl);
        $http->nothrow(false);
        $response = $http->send();
    } catch (HttpieException $e) {
        warning(sprintf('Cannot read URL %s, HTTP error: %s', $buildUrl, $e->getMessage()));
        return;
    }

    // Try to decode JSON data
    try {
        $json = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    } catch (\JsonException $e) {
        warning(sprintf('Cannot decode JSON data from URL %s, error: %s', $buildUrl, $e->getMessage()));
        return;
    }
    if (empty($json)) {
        warning(sprintf('No valid JSON data found in URL %s', $buildUrl));
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
            warning(sprintf('No valid build summary data found in JSON data in URL %s', $buildUrl));
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
