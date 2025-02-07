# Installation

* [Composer](#composer)
* [How we use Deployer recipes](#how-we-use-deployer-recipes)
* [Create a deploy.php file](#create-a-deployphp-file)
* [Overriding recipe defaults](#overriding-recipe-defaults)
* [Remove config you don't use](#remove-config-you-dont-use)
* [Deployer recipes](#deployer-recipes)
    * [PHP-FPM](#php-fpm)
    * [Slack](#slack)
* [Configuration](#configuration)
* [Hosts](#hosts)
* [Deployment tasks](#deployment-tasks)

## Composer

Install via Composer in your project:

```
composer require studio24/deployer-recipes:^2.0 --dev
```

## How we use Deployer recipes

Recipes are a set of tasks and settings to help us deploy a website. 
We create custom recipes for Studio 24 usage, some of which are based on standard Deployer recipes.

Your `deploy.php` file will load one or more recipes to help with deployment tasks.
If you need to see what a recipe does, you can view the source code. 

If an example deploy file doesn't exist for your platform you can add one to the [deployer-recipes](https://github.com/studio24/deployer-recipes) repo.

## Create a deploy.php file

The `deploy.php` file is used to store configuration for deployment. To get started copy an example file to your project to help start you off.
You only need to copy one of these.

### Craft CMS:

For deploying Craft CMS websites.

```
cp vendor/studio24/deployer-recipes/examples/craft-cms.php ./deploy.php
```

[Source](../recipe/craft-cms.php)

### WordPress

For deploying WordPress websites. 

```
cp vendor/studio24/deployer-recipes/examples/wordpress.php ./deploy.php
```

See [WordPress recipe](recipes/wordpress.md) docs.

[Source](../recipe/wordpress.php)

### Laravel:

For deploying Laravel web apps.

```
cp vendor/studio24/deployer-recipes/examples/laravel.php ./deploy.php
```

[Source](../recipe/laravel.php)

### Symfony:

For deploying Symfony web apps.

```
cp vendor/studio24/deployer-recipes/examples/symfony.php ./deploy.php
```

[Source](../recipe/symfony.php)

### Static site:

If you need to deploy a static site use this:

```
cp vendor/studio24/deployer-recipes/examples/static.php ./deploy.php
```

[Source](../recipe/static.php)

Set the following config:
* `build_commands` - an array of build commands you want to run locally to build your website
* `build_folder` - the folder that the website files are built into, this folder is uploaded to the remote server

You can optionally set the following config:
* `build_root` - the root folder files are built to locally (defaults to `~/.deployer`)

### Default:

If none of the above work, try this!

```
cp vendor/studio24/deployer-recipes/examples/default.php ./deploy.php
```

[Source](../recipe/default.php)

## Overriding recipe defaults

Many recipes contain predefined settings for `shared_files`, `shared_dirs`, `writable_dirs`, `remote_user`, `http_user`, and `webroot`.

You can view these settings in the source code for the recipe.

Please note we have some common settings in [recipe/common.php](../recipe/common.php) (e.g. http_user, remote_user). 

To add a setting to your `deploy.php` file, you can use the [add()](https://deployer.org/docs/7.x/api#add) function. This will add to the predefined settings.

To completely replace the settings in your `deploy.php` file, you can use the [set()](https://deployer.org/docs/7.x/api#set) function. This will replace the predefined settings.

## Remove config you don't use

Please make sure you remove any config that is not used for your project.

For example, the example deploy scripts contain an PHP-FPM reload command and we set the `http_user` for each host if we are using PHP-FPM. If you don't use this remove this.

## Deployer recipes

Your `deploy.php` file will load one or more recipes to help with deployment tasks.
You can add other recipes for specific tasks.

### PHP-FPM

Reload [PHP-FPM](https://deployer.org/docs/7.x/contrib/php-fpm) after a deployment.

#### Recipe

```
require 'contrib/php-fpm.php';
```

#### Deployment task 

```
// PHP-FPM reload
after('deploy', 'php-fpm:reload');
```

#### Hosting requirements

Please note the `deploy` user needs sudo permissions to run the PHP-FPM reload command.
This needs to be setup via Ansible for the hosting platform.

```
deploy   ALL=(ALL) NOPASSWD:/usr/bin/systemctl reload php*-fpm
```

### Slack

Add the [Slack recipe](recipes/slack.md) to send notifications to a Slack channel on deployment. 

## Configuration

Configuration variables are set up using the `set()` function. You can add values to an array with the `add()` function. 

You'll need to edit these settings:

* `application` - your application name
* `repository` - GitHub repo URL, please ensure this uses the SSH URL, e.g. git@github.com:studio24/project-name.git
* `disk_space_filesystem` - the filesystem volume to [check disk space](#disk_space_filesystem) when deploying

Settings that you shouldn't need to change:

* `remote_user` - remote user to login via SSH to deploy files
* `webroot` - document root for the website, usually web or public

### disk_space_filesystem

The deployment process checks disk space and warns on low capacity.
To enable the warning check you need to set `disk_space_filesystem`:

```
# AWS
set('disk_space_filesystem', '/data');

# Mythic Beasts
set('disk_space_filesystem', '/');
```

The check warns when over 80% disk space is used. You can change this with `disk_space_threshold`:

```
set('disk_space_threshold', 90);
```

### shared_files

The `shared_files` setting defines shared files that need to persist between deployments. These should be excluded from git. 

Examples include a local `.env` config file.

### shared_dirs

The `shared_dirs` setting defines shared folders that need to persist between deployments. These should be excluded from git, 
or optionally you can include the folder in git but exclude the contents.

Examples include storage folder for logs, or image upload folders.

### writable_dirs

The `writable_dirs` setting defines folders that the webserver needs to write to. 

Examples include storage folder for logs, or image upload folders.

If you want to make sure a folder exists add it to `writable_dirs`.  For example, you may set a `shared` folder to 
be shared and writable and specify some sub-folders you want to exist.  E.g.

```
set('shared_dirs', [
    'storage',
]);
set ('writeable_dirs', [
    'storage',
    'storage/backups',
    'storage/logs',
]);
```

### sync

If you need to be able to copy files from the remote server to your local Mac, then you can set 
this up via `sync`. 

The format is:

```php
set('sync', [
    'name' => [
        'remote/folder/path/' => 'local/folder/path'
    ],
]);
```

See [sync documentation](tasks/sync.md).

#### .env file

You can use a `.env` file to store sensitive information. This is loaded in the deploy.php file via:

```
set('dotenv', '{{current_path}}/.env');
```

You can then use environment variables in your deploy.php file.

For example, if you have the environment variable `API_KEY` in your `.env` file:

```
API_KEY=abc123
```

You can reference this in your deploy.php file like so:

```
getenv('API_KEY');
```

## Hosts

The host settings to enable Deployer to publish files over SSH. You will need to edit these.

The format of the host settings is:

```php
host('[environment name]')
    ->set('hostname', '[ip address]')
    ->set('http_user', '[php_fpm_user]')
    ->set('deploy_path', '/path/to/project_root')
    ->set('log_files', [
        '/var/log/apache2/DOMAIN.co.uk.access.log',
        '/var/log/apache2/DOMAIN.co.uk.error.log',
    ])
    ->set('url', '[website url]');
```

An example:

```php
host('production')
    ->set('hostname', '1.2.3.4')
    ->set('http_user', 'production')
    ->set('deploy_path', '/var/www/vhosts/studio24.net/production')
    ->set('log_files', [
        'storage/logs/*.log',
        '/var/log/apache2/studio24.net.access.log',
        '/var/log/apache2/studio24.net.error.log',
    ])
    ->set('url', 'https://www.studio24.net');
```

The key information you need to set is:

* `host('[environment name]')` - Environment name
* `hostname` - Hostname or IP address to deploy to
* `http_user` - The PHP-FPM user (not required if you are not using PHP-FPM)
* `deploy_path` - Path to deploy files to
* `log_files` - Array of log files (optional)
* `url` - The URL of the website

You can set log_files to one file, multiple files, or use * to pattern match valid log files (e.g. `storage/logs/*.log`).

See [hosts documentation](https://deployer.org/docs/7.x/hosts).

## Deployment tasks

You can add any custom deployment tasks here. Hopefully the common tasks required to deploy your project will be taken care of by the recipe you are using.

### Running a custom task
We recommend leaving the default tasks as defined in the Deployer recipe and using the [before()](https://deployer.org/docs/7.x/api#before) 
and [after()](https://deployer.org/docs/7.x/api#after) functions to add other tasks to run at certain points in the deployment process.

E.g. 

```
task('my-custom-task', function () {
    // do something
});
after('deploy:success', 'my-custom-task');
```

You can see the different deployment steps by passing the `--plan` option to your deploy command. 
Also see Deplopyer [common tasks](https://deployer.org/docs/7.x/recipe/common#tasks).

### Running multiple tasks

If you call the before() or after() function multiple times for the same task, then it will override previous calls. 
To run multiple tasks just create a custom task which you can pass an array of tasks to run. E.g.

```php
task('post-deploy-tasks', [
    'slack:notify:success',
    'my-custom-task'
]);
after('deploy:success', 'post-deploy-tasks');
```

### Composer in sub-paths

If you need to run Composer in a sub-path, e.g. a WordPress plugin, add the following configuration:

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

Please note it is recommended to only use Composer in the project root folder to avoid clashes between package versions.
