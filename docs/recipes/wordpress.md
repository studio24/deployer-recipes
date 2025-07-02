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

WordPress core is not in source control and should have auto-updating enabled on the server.  

You can set the WordPress path via:

```
set('wordpress_path', 'web/wordpress');
```

This will add `wordpress_path` to `shared_dirs` and `writable_dirs` automatically.

If WordPress does not exist in this path, it installs it.

It does not update WordPress on deployment.

If you need to manually update WordPress run:

```bash
dep wp core update staging 
```

You can update to a specific version via:

```bash
dep wp core update --version=<version> staging 
```

Please note this requires WP CLI to exist on the server.

### Composer

If `composer.json` exists in the project root, the `deploy:vendors` task is automatically run.

You can check this by running `dep tree deploy` which will show you the tasks to be run.

#### Multiple Composer files in a WordPress project

It is not recommended to have more than one composer.json file in a project. If you do have one, you should move the 
dependencies into the root composer file.

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

### Required configuration

* `wordpress_path`: directory to install WordPress to relative to the release_path

