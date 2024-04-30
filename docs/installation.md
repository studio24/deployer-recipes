# Installation

## Composer

Install via Composer in your project:

```
composer require studio24/deployer-recipes:^2.0 --dev
```  

## Deployer recipes

We create custom recipes for Studio 24 usage, making use of standard Deployer recipes where these work for us. Take a look
at the recipe source code to see what it does and what defaults it sets. You can override the defaults in your deploy.php file if you need to.

If an example deploy file doesn't exist for your platform you can add one to the [deployer-recipes](https://github.com/studio24/deployer-recipes) repo.

## Create a deploy.php file

The `deploy.php` file is used to store configuration for deployment. You can copy an example file to your project to help start you off.

### Default: 

```
cp vendor/studio24/deployer-recipes/examples/default.php ./deploy.php
```

[Source](../recipe/default.php).

### Craft CMS:

```
cp vendor/studio24/deployer-recipes/examples/craft-cms.php ./deploy.php
```

[Source](../recipe/craft-cms.php).

### Laravel:

```
cp vendor/studio24/deployer-recipes/examples/laravel.php ./deploy.php
```

[Source](../recipe/laravel.php).

### Symfony:

```
cp vendor/studio24/deployer-recipes/examples/symfony.php ./deploy.php
```

[Source](../recipe/symfony.php).

### WordPress

```
cp vendor/studio24/deployer-recipes/examples/wordpress.php ./deploy.php
```

[Source](../recipe/wordpress.php).

## Edit the deploy.php file

The example deploy file contains setup and defaults for the platform you are using, you will need to review this and update it for your specific project. 

**Note:** please make sure you remove any config that is not used for your project.

The different sections of the deploy file are explained below.

## 1. Deployer recipe

The Deployer recipe the deploy script is based on. 

## 2. Deployment configuration variables

Configuration variables are set up using the `set()` function. You'll need to edit these.

* `application` - your application name
* `repository` - GitHub repo URL, please ensure this uses the SSH URL, e.g. git@github.com:studio24/project-name.git
* `http_user` - HTTP user that the webserver runs as (when we use PHP-FPM this is normally `production` or `staging`), remove this if you're not using PHP-FPM
* `log_files` - Path to log files, separate multiple files with a comma

Settings that you shouldn't need to change:

* `remote_user` - remote user to login via SSH to deploy files
* `webroot` - document root for the website, usually web or public

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

### Check disk space

Deployment checks disk space and warns on low capacity. This checks on the `data` filesystem volume and warns when over 80% diskspace is used. 
You can change this with `disk_space_filesystem` and `disk_space_threshold` respectively.

```
set('disk_space_filesystem', '/my-data');
set('disk_space_threshold', 90);
```

## 3. Hosts

The host settings to enable Deployer to publish files over SSH. You will need to edit these.

The format of the host settings is:

```php
host('[environment name]')
    ->set('hostname', '[ip address]')
    ->set('deploy_path', '/path/to/[environment]')
    ->set('url', '[website url]');
```

An example:

```php
host('production')
    ->set('hostname', '63.34.69.8')
    ->set('deploy_path', '/data/var/www/vhosts/studio24.net/production')
    ->set('url', 'https://www.studio24.net');
```

The key information you need to set is:

* `host('[environment name]')` - Environment name
* `hostname` - Hostname or IP address to deploy to
* `deploy_path` - Path to deploy files to
* `log_files` - Path to log files (optional)
* `url` - The URL of the website

You can set log_files to one file, multiple files, or use * to pattern match valid log files (e.g. storage/logs/*.log).

See [hosts documentation](https://deployer.org/docs/7.x/hosts).

## 4. Deployment tasks

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

You can see the different deployment steps in the recipe documentation. 

You can refer to the Deployer recipe source code to review when to run a custom task. Some key tasks:

* deploy:prepare - deployment is prepared, code is published to a release folder, everything is done prior to actually making this release live
* deploy:publish - updates the current deployment to point to the new release (at which point it is live)
* deploy:success - deployment is successful
* deploy:failed - deployment has failed

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
