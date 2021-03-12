<?php

namespace Deployer;

desc('Display the build_summary from the webserver');
task('s24:show-summary', function () {
    
    // Get build file
    $file = get('url') . '/_build_summary.json';
    $json = file_get_contents($file);
    if ($json === false) {
        writeLn(sprintf('<comment>Cannot load build summary from %s</comment>', $file));
        return;
    }
    try {
        $json = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    } catch (\JsonException $e) {
        writeLn(sprintf('<comment>Cannot decode JSON build summary from %s</comment>', $file));
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

    // Output last build info
    $date = new \DateTimeImmutable($buildData['deploy_datetime']);
    $summary = sprintf(
        'Currently deployed branch on the <fg=blue;options=bold>%s</> environment is <fg=red;options=bold>%s</>, deployed on <fg=black;options=bold>%s</> by <fg=green;options=bold>%s</>.',
        $buildData['environment'],
        $buildData['git_branch'],
        $date->format('l, F d \a\t h:iA'),
        $buildData['deployed_by'],
    );

    writeLn(' ');
    writeLn('<options=bold>Last build summary:</>');
    writeLn($summary);
    writeLn(' ');
});
