<?php

namespace Deployer;

use Deployer\Task\Context;

desc('Display server disk usage prior to deployment');
task('s24:display-disk-space', function () {
    $target = Context::get()->getHost()->getLabels();

    output()->write(
        runLocally("ssh ". $target['stage']. " df -kh --exclude-type=tmpfs --exclude-type=devtmpfs") . "\n"
    );
    writeln(' ');

});
