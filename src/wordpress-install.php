<?php

namespace Deployer;

desc('Installs Wordpress core for use outside of the repo');
task('s24:wordpress-install',function(){

    cd('{{release_path}}/web/');
    run('mkdir wordpress');
    cd('{{release_path}}/web/wordpress/');
    $stage = get('stage');
    run('WP_ENV='.$stage.' wp core download');
        if(!askConfirmation('Continue with Wordpress install?')) {
            die('Ok, installation cancelled.');
        }
});
