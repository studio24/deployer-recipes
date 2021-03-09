# Check branch recipe

Checks the branch for deployment, to ensure that only the main/master branch is deployed to Master unless force is used.

## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/src/check-branch.php';
```

## Configuration
Requires the main branch to be set in deploy.php
```
$main_branch = 'master'; or $main_branch = 'main';
```

## Tasks

- `s24:check-branch` – checks which stage and branch you are trying to deploy to. Ensures that non main branches deployed to production have to be forced.


## Usage

Add task to your `deploy.php` script:  
**Note:** it is suggested to use in conjunction with [confirm deployemnt](confirm-deployment.md)

```
task('deploy', [
    ...
    // Add after deploy:info
    'deploy:info',

    's24:check-branch',
    's24:confirm-deployment',    
    ...
]);
```

Default protection result
```
dep deploy production --branch=hotfix
```
will result in the exception
```
You cannot deploy hotfix  to production
  Deployment abandoned  
```
To force a non main branch to be deployed use
```
dep deploy production --branch=hotfix --force=true
```
which will result in 
```
Forcing deployment of hotfix to production.
✔ Ok
```
