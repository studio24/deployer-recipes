<?php

namespace Deployer;

use Deployer\Task\Context;

desc('Display server disk usage prior to deployment');
task('s24:display-disk-space', function () {
    $target = Context::get()->getHost();
    output()->write(runLocally("ssh $target df -kh --exclude-type=tmpfs --exclude-type=devtmpfs"));
    writeln(' ');
});
