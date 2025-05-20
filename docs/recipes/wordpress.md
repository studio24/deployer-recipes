# WordPress

Deploy a WordPress site.

## Recipe

You can copy an example deployment file:

```
cp vendor/studio24/deployer-recipes/examples/wordpress.php ./deploy.php
```

## Tasks

The static site recipe has 2 new tasks it runs:

### WordPress

You can install WordPress on deployment to `wordpress_path` by adding this config variable:

```
set('wordpress_path', 'web/wordpress');
```

And add this task to run:

```
after('deploy:prepare', 'deploy:wordpress_install');
```

### Composer

If `composer.json` exists in the project root, the `deploy:vendors` task is automatically run.

You can also run Composer in sub-folders, however, please note it is recommended you only use one root `composer.json` file in your project.

To run Composer in sub-folders add:

```php
// Custom (non-root) composer installs
set('composer_paths', [
    'web/wp-content/plugins/s24-wp-image-optimiser'
]);
```

And add this task to run:

```php
// Custom (non-root) composer installs
after('deploy:prepare', 'vendors-subpath');
```

## Configuration

### Optional configuration

* `wordpress_path`: directory to install WordPress to relative to the release_path

