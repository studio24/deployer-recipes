<?php

namespace Deployer;

use Deployer\Task\Context;

desc('Display server disk usage prior to deployment');
task('s24:display-disk-space', function () {
    run("df -kh --exclude-type=tmpfs --exclude-type=devtmpfs", real_time_output: true);
    writeln(' ');
});