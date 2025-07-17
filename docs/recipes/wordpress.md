# WordPress

Deploy a WordPress site.

[Source](../../recipe/wordpress.php)

## Background

We manage our WordPress sites using the following directory structure:

```
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
├── composer.json
├── .env
└── README.md
```

WordPress is not in source control and is installed to `web/wordpress`. This folder is set to be writable to support auto-updates to WordPress core.

Source controlled plugins and themes are in the `web/content` folder.

Configuration is stored in `web/wp-config.php`

Sensitive or environment configuration values are stored in a `.env` file in the project root. 

Documentation is stored in the `docs` folder.

## Installation

### Requirements

This recipe requires [WP CLI](https://wp-cli.org/) to exist on the remote server.

### Recipe

You can copy an example deployment file:

```
cp vendor/studio24/deployer-recipes/examples/wordpress.php ./deploy.php
```

### Loading environment variables in wp-config

Local environment variables set in `.env` can be loaded in your wp-config file. 

First install [vlucas/phpdotenv](https://packagist.org/packages/vlucas/phpdotenv) and include the Composer autoloader.

Set your local environment variables in `.env` via name and value pairs:

```
DB_NAME="wp_database"
S3_BUCKET="devbucket"
```

This can be loaded in your wp-config file via:

```php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
```

You can then reference the environment values in wp-config via `$_ENV`. E.g.

```php
define('DB_NAME', $_ENV['DB_NAME']);
```

You can also refer to other environment variables in your `.env` file via `${NAME}`. E.g. 

```
BASE_DIR="/var/webroot/project-root"
CACHE_DIR="${BASE_DIR}/cache"
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

