<?php

namespace Deployer;

desc('Creates a _build_summary.json file in the webserver doc root');
task('s24:build-summary', function () {
    cd('{{release_path}}/' . get('webroot'));
    $build_data = [
        'environment' => get('alias'),
        'deploy_datetime' => date('c'),
        'git_branch' => get('branch'),
        'git_commit' => get('release_revision'),
        'deployed_by' => get('user'),
    ];

    run("echo '" . json_encode($build_data, JSON_PRETTY_PRINT) . "' > _build_summary.json");

    $url = rtrim(get('url'), '/') . '/';
    writeln('Build summary saved to: ' . $url . '_build_summary.json');
});
