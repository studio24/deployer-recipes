<?php

namespace Deployer;

desc('Creates a _build_summary.json file in the webserver doc root');
task('Studio24:build-summary', function () {
    cd('{{release_path}}/' . get('webroot'));
    $build_data = [
        'environment' => get('stage'),
        'buildDateTime' => date('Ymd_His'),
        'gitBranch' => get('branch'),
        'commitId' => run('git rev-parse HEAD'),
        'deployedBy' => runLocally('git config user.name') . ' (' . runLocally('git config user.email') . ')',
    ];

    run("echo '" . json_encode($build_data, JSON_PRETTY_PRINT) . "' > _build_summary.json");

    $url = rtrim(get('url'), '/') . '/';
    writeln('Build summary saved to: ' . $url . '_build_summary.json');
});
