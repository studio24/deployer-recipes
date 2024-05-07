<?php

namespace Deployer;

desc('Check you can connect to the host via SSH');
task('check:ssh', function () {

    // Get timeout value, defaults to 10 seconds to give feedback quickly
    $timeout = get('check-ssh-timeout', 10);

    $sshHost = get('remote_user') . '@' . get('hostname');
    info('Testing SSH connection to: <options=bold>' . $sshHost . '</>');
    runLocally(sprintf('ssh -T -o "ConnectTimeout=%d" %s', $timeout, $sshHost));
    info('Connected OK!');
});
