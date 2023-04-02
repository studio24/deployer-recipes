<?php

namespace Deployer;

require_once 'recipe/wordpress.php';
require_once __DIR__ . '/common.php';

set('shared_files', [
    'config/wp-config.local.php'
]);

set('shared_dirs', [
    '.well-known',
    'web/wp-content/uploads',
    'web/wp-content/cache',
]);

set('writable_dirs', [
    'web/wp-content/uploads',
    'web/wp-content/cache'
]);

set('sync', [
    'images' => [
        'web/wp-content/uploads/' => 'web/wp-content/uploads'
    ]
]);
