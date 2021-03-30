# Build summary recipe

Checks that deployment is running via the local deploy
## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/src/check-deployer.php';
```

## Configuration
No configuration is required.

## Tasks

- `s24:check-deployer` – checks whether you are running local deployer, if not it stops the deployment

## Usage

Add task to the start of your `deploy.php` script:

```
task('deploy', [
    ...
    // Add before deploy:info
    's24:check-deployer',

    // Run initial checks
    'deploy:info',
    ...
]);
```
