<?php

namespace Deployer;

desc('Display server disk usage prior to deployment');
task('s24:display-disk-space', function () {
    $target = get('target');
    output()->write(runLocally("ssh deploy@$target df -kh --exclude-type=tmpfs --exclude-type=devtmpfs"));
    writeln(' ');
});
