<?php

namespace Deployer;

desc('Creates a _build_summary.json file on the webserver');
task('Studio24:build-summary',function() {
cd('{{release_path}}/'.get('webroot'));
$build_data = [
'environment' => get('stage'),
'buildDateTime' => date('Ymd_His'),
'gitBranch' => get('branch'),
'commitId' => run('git rev-parse HEAD'),
'deployedBy' => runLocally('git config user.name') . ' (' . runLocally('git config user.email') . ')',
];

    run('echo \''.json_encode($build_data).'\' > _build_summary.json');

    $url = get('url');
    $url = rtrim($url, '/') . '/';


    writeln ('Build summary located at ' . $url . '_build_summary.json');

});
