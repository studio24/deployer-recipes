<?php

namespace Deployer;

desc('Check currently used deployer path');
task('s24:check-deployer', function () {

    list($scriptPath) = get_included_files();

    if (strpos($scriptPath, 'vendor/deployer') !== false) {
        writeln('Local Deployer');
    } else {
        writeln(' ');
        writeln('<comment>Pleaae run using local deployer with </>');
        writeln('<info>./vendor/bin/dep</>');
        writeln('');
        throw new \RuntimeException("Deployment abandoned");
    }
});
