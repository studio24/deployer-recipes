<?php

namespace Deployer;

desc('Display the build_summary from the webserver');
task('s24:show-summary', function () {

    $response = file_get_contents(get('url') . '/_build_summary.json');
    if ($response === false) {
        writeLn(sprintf('<comment>The build_summary.json file is unavailable. HTTP transport error: %s</comment>', $e->getMessage()));
    }
    try {
        $json = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    } catch (\JsonException $e) {
        writeLn(sprintf('<comment>Cannot decode JSON build summary from URL %s, error: %s</comment>', $buildUrl, $e->getMessage()));
        return;
    }
    if (empty($json)) {
        writeLn(sprintf('<comment>No data found in JSON build summary from URL %s</comment>', $buildUrl));
        return;
    }

    // Support old and new build data variables
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
    }

    // Get repo link
    if (preg_match('/^(.+)@(.+):(.+)\.git$/i', get('repository'), $m)) {
        $gitHost = $m[2];
        $gitRepo = $m[3];

        switch ($gitHost) {
            case 'github.com':
                $buildData['git_commit_url'] = 'https://github.com/' . $gitRepo . '/commits/' .  $buildData['git_commit'];
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
    $date = new \DateTimeImmutable($buildData['deploy_datetime']);
    $summary = sprintf(
        '<options=bold>Last build:</> <info>%s</> deployed <info>%s</> branch to <info>%s</> environment on <info>%s</>',
        $buildData['deployed_by'],
        $buildData['git_branch'],
        $buildData['environment'],
        $date->format('r')
    );

    writeLn('');
    writeLn($summary);
    if (isset($buildData['git_commit_url'])) {
        writeLn('<options=bold>View git commit:</> ' . $buildData['git_commit_url']);
    }
    writeLn('');
});
