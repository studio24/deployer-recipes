# Check branch recipe

Checks the branch for deployment, to ensure that only the default branch (main/master) is deployed to production unless force is used.

## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/tasks/check-branch.php';
```

## Configuration
No configuration required

## Tasks

- `s24:check-branch` – checks which stage and branch you are trying to deploy to. Ensures that non main branches deployed to production have to be forced.


## Usage

Add task to your `deploy.php` script:  
**Note:** it is suggested to use in conjunction with [confirm continue](confirm-continue.md)

```
task('deploy', [
    ...
    // Add after deploy:info
    'deploy:info',

    's24:check-branch',
    's24:confirm-continue',    
    ...
]);
```

Default protection result
```
vendor/bin/dep deploy production --branch=hotfix
```
will result in the exception
```
You cannot deploy hotfix  to production
  Deployment abandoned  
```
To force a non main branch to be deployed use
```
vendor/bin/dep deploy production --branch=hotfix --force=true
```
which will result in 
```
Forcing deployment of hotfix to production.
✔ Ok
```
This command uses ```LANG=C ``` to ensure the default locale settings for users that are set to different locales. This makes sure that the 'main' branch name is returned correctly from github.
