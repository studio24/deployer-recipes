<?php

namespace Deployer;

desc('Creates a _build_summary.json file in the webserver doc root');
task('build-summary', function () {

    $webroot = get('webroot');
    if (empty($webroot)) {
        throw error('Deployer config setting webroot is not set, you must set this via set("webroot", "value") in deploy.php');
    }

    cd('{{release_path}}/' . $webroot);
    $build_data = [
        'environment' => get('alias'),
        'deploy_datetime' => date('c'),
        'git_branch' => get('target'),
        'git_commit' => get('release_revision'),
        'deployed_by' => get('user'),
    ];

    run("echo '" . json_encode($build_data, JSON_PRETTY_PRINT) . "' > _build_summary.json");

    $url = rtrim(get('url'), '/') . '/';
    info('Build summary saved to: <options=bold>' . $url . '_build_summary.json</>');
});
