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

Please note this requires WP CLI to exist on the server.

### Composer

If `composer.json` exists in the project root, the `deploy:vendors` task is automatically run.

You can check this by running `dep tree deploy` which will show you the tasks to be run.

#### Composer in sub-folders

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

## WP CLI
If you need to call any [WP CLI](https://wp-cli.org/) commands this recipe includes the `wp()` function to allow you to do this.

This requires WP CLI to exist on the server.

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

## Configuration

### Optional configuration

* `wordpress_path`: directory to install WordPress to relative to the release_path

