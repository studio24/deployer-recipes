# Studio 24 common tasks

## Installing

Add this line in your `deploy.php` file after the Deployer recipe you are using:

```php
require 'vendor/studio24/deployer-recipes/common.php';
```

E.g. if you are using the standard Deployer common recipe:

```php
/**
 * Deployer recipes we are using for this website
 */
require 'recipe/common.php';
require 'vendor/studio24/deployer-recipes/common.php';
```

## Settings

This sets the following default settings, which you can override in your `deploy.php` script: 
```
set('remote_user', 'deploy');
set('http_user', 'apache');
```

## Tasks

### s24:pre-deploy-checks

Runs before the `deploy` task:

* [s24:check-branch](tasks/check-branch.md)
* [s24:show-summary](tasks/show-summary.md)
* [s24:display-disk-space](tasks/display-disk-space.md)
* [s24:confirm-continue](tasks/confirm-continue.md)

### s24:build-summary

The [s24:build-summary](tasks/build-summary.md) task runs before the `deploy:publish` task.

### deploy:unlock

The [deploy:unlock](https://deployer.org/docs/7.x/recipe/deploy/lock#deployunlock) task runs after the `deploy:failed` task.