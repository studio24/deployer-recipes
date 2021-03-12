<?php
namespace Deployer;

desc('Run composer install in a sub-path');
task('s24:vendors-subpath', function () {
    $previousOptions = get('composer_options');
    $paths = get('composer_paths');
    $composer_paths = [
        'web/wp-content/plugins/s24-wp-image-optimiser'
    ];

    foreach ($paths as $path) {
        set('composer_options', $previousOptions . ' --working-dir=' . $path);
        invoke('deploy:vendors');
    }

    // Reset composer options to previous value
    set('composer_options', $previousOptions);
});
