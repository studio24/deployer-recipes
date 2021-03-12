<?php

namespace Deployer;

desc('Display the build_summary from the webserver');
task('s24:show-summary', function () {
    $url = get('url');
    $json = file_get_contents("$url/_build_summary.json");
    $json = json_decode($json, true);

    if ($json) {
        $date = new \DateTime($json['deploy_datetime']);
        $date = $date->format('l, F d \a\t h:iA');
        $summary = 'Currently deployed branch on the <fg=blue;options=bold>'.$json['environment'].'</> environment is <fg=red;options=bold>'.$json['git_branch'].'</>, deployed on <fg=black;options=bold>'.$date.'</> by <fg=green;options=bold>'.$json['deployed_by'].'</>.';
    } else {
        $summary = 'Unable to get a summary of the previous deployment.';
    }

    writeLn(' ');
    writeLn('<options=bold>Build Summary:</>');
    writeLn(' ');
    writeLn($summary);
    writeLn(' ');
});
