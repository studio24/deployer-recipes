<?php

namespace Deployer;

desc('Installs Wordpress core for use if Wordpress is outside of the repo');
task('s24:wordpress-install', function () {

    $webroot = get('webroot');

    writeln(" ");
    writeln("<fg=blue;options=bold>Installing Wordpress core into {{release_path}}/$webroot/wordpress</>");
    writeln(" ");


    cd("{{release_path}}/$webroot/");
    run('mkdir wordpress');
    cd("{{release_path}}/$webroot/wordpress/");
    $stage = get('stage');
    run('WP_ENV='.$stage.' wp core download');
});
