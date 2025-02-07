# WordPress

Deploy a WordPress site

## Recipe

```
require 'vendor/studio24/deployer-recipes/recipe/wordpress.php';
```

## Requirements
WP-CLI must be available on the remote server.

## Configuration
This recipe downloads WordPress on deployment, by default to the folder `web/wordpress/`. You can change this via: 

```php
// WordPress core folder
set('wordpress_core_folder', 'web/wordpress/');
```

## WP CLI
If you need to call any [WP CLI](https://wp-cli.org/) commands this recipe includes the `wp()` function to allow you to do this.

Usage:

```php
wp('command');
```

E.g. to run `wp core version`

```php
wp('core version');
```

This automatically sets the current environment using the `stage` variable. You can pass this manually as the second param:

```php
wp('core version', 'staging');
```

## Run Composer

If you need to run Composer in the root folder add `deploy:vendors` to the deploy task in your `deploy.php` file: 

```php
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'deploy:publish',
]);
```

To run Composer in a sub-folder (which isn't recommended) 

```php
// Custom (non-root) composer installs
set('composer_paths', [
    'web/wp-content/plugins/s24-wp-image-optimiser'
]);
```