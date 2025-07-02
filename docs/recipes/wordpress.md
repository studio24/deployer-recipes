# WordPress

Deploy a WordPress site.

[Source](../../recipe/wordpress.php)

## Background

We manage our WordPress sites using the following directory structure:

```
├── config
|   ├── wp-config.base.php
|   ├── wp-config.local.php
|   ├── wp-config.production.php
|   ├── wp-config.staging.php
|   └── wp-config.development.php
├── docs
└── web
|   ├── content
|   |   ├── cache
|   |   ├── mu-plugins
|   |   ├── plugins
|   |   ├── themes
|   |   └── uploads
|   ├── wordpress
|   └── wp-config.php
└── README.md
```

WordPress is not in source control and is installed to `web/wordpress`

Source controlled plugins and themes are in the `web/content` folder.

Configuration is stored in the `config` folder:
* `wp-config.base.php` - base WordPress settings common across all enviroments
* `wp-config.local.php` - sensitive settings such as database passwords (excluded from source control)
* `wp-config.production.php` - production WordPress settings
* `wp-config.staging.php` - staging WordPress settings
* `wp-config.development.php` - development WordPress settings

Documentation is stored in the `docs` folder.

## Installation

### Requirements

This recipe requires [WP CLI](https://wp-cli.org/) to exist on the remote server.

### Recipe

You can copy an example deployment file:

```
cp vendor/studio24/deployer-recipes/examples/wordpress.php ./deploy.php
```

## Tasks

The static site recipe has 2 new tasks it runs:

### WordPress

WordPress core is not in source control and should have auto-update enabled on the server.  

You can change the WordPress path via:

```
set('wordpress_path', 'web/wordpress');
```

If you change it from the default, you will need to add this path to `shared_dirs` and `writable_dirs`.

#### WordPress update strategy

To let WordPress run updates automatically the `WP_AUTO_UPDATE_CORE` setting must exist in your config:

```
// Minor updates are enabled, development, and major updates are disabled (recommended for production)
define('WP_AUTO_UPDATE_CORE', 'minor');

// Development, minor, and major updates are all enabled
define('WP_AUTO_UPDATE_CORE', true);
```

It is also possible to configure this via [filters](https://developer.wordpress.org/advanced-administration/upgrade/upgrading/#configuration-via-filters).

#### On deployment

On deployment, if WordPress does not exist in this path, it installs it. If WordPress does exist, no core updates are made on deployment.

#### Manually running WordPress updates

If you need to manually update WordPress run:

```bash
dep wp core update staging 
```

You can update to a specific version via:

```bash
dep wp core update --version=<version> staging 
```

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

