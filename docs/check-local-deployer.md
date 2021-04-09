# Check local deployer recipe

Checks that deployment is running via the local Deployer install.
## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/tasks/check-local-deployer.php';
```

## Configuration
The recipe detects the first item in the array of file paths only
````
$scriptPath = get_included_files()[0];
````

## Tasks

- `s24:check-local-deployer` – checks whether you are running local deployer, if not it stops the deployment

## Usage

Add task to the start of your `deploy.php` script:

```
task('deploy', [
    ...
    // Add before deploy:info
    's24:check-local-deployer',

    // Run initial checks
    'deploy:info',
    ...
]);
```
