# Installation

How to create a `deploy.php` file for your project.

## Composer

Install via Composer:

```
composer require studio24/deployer-recipes:^2.0 --dev
```  

## Example deploy.php file

You can copy an example [deploy.php](../examples/deploy.php) file to your project to help start you off:

```
cp vendor/studio24/deployer-recipes/examples/deploy.php ./deploy.php
```

## 1. Deployer recipe

It is recommended you use a standard Deployer recipe as the base for your deploy script.

The example deploy.php script requires the standard Deployer [commmon](https://deployer.org/docs/7.x/recipe/common) recipe. 
You can replace this for another Deployer recipe to match your project. 

Default value:

```php
require 'recipe/common.php';
```

This should be followed by the Studio 24 Deployer recipe common file:

```php
require 'vendor/studio24/deployer-recipes/recipe/common.php';
```

Deployer contains [recipes for many standard PHP frameworks](https://deployer.org/docs/7.x/recipe) (some are detailed below).

Please note it is not recommended to use the Deployer WordPress recipe.

### Composer

Runs [composer install](https://deployer.org/docs/7.x/recipe/composer) (to your project root) during deployment.

```
require 'recipe/composer.php';
```

### CraftCMS

Deploys [CraftCMS](https://deployer.org/docs/7.x/recipe/craftcms).

```php
require 'recipe/craftcms.php';
```

## 2. Deployment configuration variables

There are a number of `set()` function calls which are used in Deployer to set configuration values. 

* application - your application name
* repository - GitHub repo URL, please ensure this uses the SSH URL, e.g. git@github.com:studio24/project-name.git
* webroot - document root for the website, usually web or public

### shared_files

If your web application has persistent files, that need to not change between deployments, set 
these up as `shared_files`

Examples include your local `.env` config file.

### shared_dirs

If your web application has persistent folders, that need to not change between deployments, set
these up as `shared_dirs`

Examples include storage folder for logs, or image upload folders.

### writable_dirs

If your web application needs to write files to a folder, make sure you set it up in 
`writable_dirs` to ensure the webserver has permission to write files. 

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

You can then sync files via:

```
./vendor/bin/dep sync name
```

See [sync documentation](tasks/sync.md).

### git_ssh_command

If your webserver is using OpenSSH version older than v7.6, updating the code may fail with the error message 
_unsupported option "accept-new"_. In this case, override the Git SSH command with:

```php
set('git_ssh_command', 'ssh');
```

## 3. Hosts

Set up the host settings to enable Deployer to publish files over SSH.

Eac host statement should look like:

```php
host('production')
    ->set('hostname', '63.34.69.8')
    ->set('deploy_path', '/data/var/www/vhosts/studio24.net/production')
    ->set('url', 'https://www.studio24.net');
```

The key information you need to set is:

* `host('production')` - The host alias, or environment name
* `hostname` - The hostname, or host IP address
* `deploy_path` - The path to deploy files to
* `log_files` - Path to log files (optional)
* `url` - The URL of the website

You can set log_files to one file, multiple files, or use * to pattern match valid log files (e.g. storage/logs/*.log).

See [hosts documentation](https://deployer.org/docs/7.x/hosts).

## 4. Deployment tasks

We recommend leaving the default tasks as defined in the Deployer recipe and using the [before](https://deployer.org/docs/7.x/api#before) 
and [after](https://deployer.org/docs/7.x/api#after) functions to add other tasks to run. 

You can refer to the Deployer recipe source code to review when to run a custom task. Some key tasks:

* deploy:prepare - deployment is prepared, code is published to a release folder, everything is done prior to actually making this release live
* deploy:publish - updates the current deployment to point to the new release (at which point it is live)
* deploy:success - deployment is successful
* deploy:failed - deployment has failed

### Running multiple tasks

If you call the before or after function multiple times for the same task, then it will override previous calls. To run 
multiple tasks  you need to create a custom task which you can pass an array of tasks to run. E.g.

```php
task('post-deploy-tasks', [
    'slack:notify:success',
    'some-other-task'
]);
after('deploy:success', 'post-deploy-tasks');
```

### Slack notifications

We use the [Slack recipe](https://deployer.org/docs/7.x/contrib/slack) to send Slack notifications to the #deployments 
channel.

First add [Deployer to Slack](https://deployer.org/docs/7.x/contrib/slack).

Add the Studio 24 Slack recipe, which contains our common setup for Slack notifications:

```php
require 'vendor/studio24/deployer-recipes/recipe/slack.php';
```

Set the Slack webhook URL in your deploy.php configuration:

```php
set('slack_webhook', 'https://hooks.slack.com/services/xxx/xxx/xxx');
```

### Composer in sub-paths

#### Composer in sub-paths

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
