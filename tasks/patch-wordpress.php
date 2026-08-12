<?php

namespace Deployer;

/**
 * Patch WordPress
 *
 * This is designed to help run minor updates to WordPress via Deployer
 *
 * It run updates to the latest minor/patch version, tests the homepage returns HTTP 200, and if it fails rolls back
 *
 * @param string $type
 * @return void
 * @throws Exception\Exception
 * @throws Exception\RunException
 * @throws Exception\TimeoutException
 */
function patchWordPress(string $type = 'wpcli')
{
    // Check current version
    $oldVersion = run('wp version');

    // Run updates
    switch ($type) {
        case 'wpcli':
            run('wp update --minor', real_time_output: true);
            break;
        case 'composer':
            run('composer update johnpbloch/wordpress-core --patch-only', real_time_output: true);
            break;
        default:
            error('Type must be one of: wpcli, composer');
            return;
    }

    $newVersion = run('wp version');
    info(sprintf('Updated WordPress from %s to %s', $oldVersion, $newVersion));

    // Test homepage
    $url = get('url', null);
    if ($url === null) {
        warning('Cannot test website URL, url variable not set');
        return;
    }
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_exec($handle);
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    if ($httpCode == 200) {
        info('All OK!');
        return;
    }

    // Rollback if homepage fails 200 HTTP status test
    warning(sprintf('Website URL %s does not work and returns HTTP status code %d', $url, $httpCode));
    switch ($type) {
        case 'wpcli':
            run(sprintf('wp update --version=%s', $oldVersion), real_time_output: true);
            break;
        case 'composer':
            run(sprintf('composer update --with johnpbloch/wordpress-core:%s', $oldVersion), real_time_output: true);
            break;
    }
    info(sprintf('Rolled back WordPress to %s', $oldVersion));
}


/**
 * Usage: use this in the WordPress recipe files
 */

//desc('Update security patches for WordPress via WP CLI');
//task('wordpress:patch', function() {
//    patchWordPress('wpcli');
//});
//
//desc('Update security patches for WordPress via Composer');
//task('wordpress:patch', function() {
//    patchWordPress('composer');
//});
