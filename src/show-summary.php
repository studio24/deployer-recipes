<?php

namespace Deployer;

desc('Display the build_summary from the webserver');
task('Studio24:show-summary',function() {
    $json = run('curl {{url}}/_build_summary.json');
    $json = json_decode($json,true);

    if ($json) {
        $date = \DateTime::createFromFormat ('Ymd_His' , $json['buildDateTime']);
        $date = $date->format('l, F d \a\t h:iA');
        $summary = 'Currently deployed branch on the <fg=blue;options=bold>'.$json['environment'].'</> environment is <fg=red;options=bold>'.$json['gitBranch'].'</>, deployed on <fg=black;options=bold>'.$date.'</> by <fg=green;options=bold>'.$json['deployedBy'].'</>.';

    } else {
        $summary = 'Unable to get a summary of the previous deployment.';
    }

    writeLn (' ');
    writeLn ('<options=bold>Build Summary:</>');
    writeLn (' ');
    writeLn ($summary);
    writeLn (' ');
});

