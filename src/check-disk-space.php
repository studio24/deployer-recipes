<?php

namespace Deployer;



desc('Display server disk usage prior to deployment');
task('s24:disk-usage',function() {
    $target = get('target');
    output()->write(runLocally("ssh deploy@$target df -kh"));

});
