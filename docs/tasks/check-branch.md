# Check branch recipe

Checks the branch for deployment, to ensure that only the default branch (main/master) is deployed to production unless force is used.

## Usage

Either [install all Studio 24 tasks](../installation.md) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/tasks/check-branch.php';
```

## Configuration
No configuration required

## Tasks

- `check:branch` – checks which stage and branch you are trying to deploy to. Ensures that non main branches deployed to production have to be forced.

## Usage

This automatically runs in the pre deploy tasks.

This:
* Ensures only the default branch is deployed to production
* Allows you to deploy non-default branches to production with --force
* Sets the correct branch and target (to the default branch) if no branch is passsed
