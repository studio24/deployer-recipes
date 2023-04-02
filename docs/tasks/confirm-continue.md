# Confirm deployment recipe

Simple recipe to ask confirmation from user before continuing with deployment.

## Usage

Either [install all Studio 24 tasks](../installation.md) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/tasks/confirm-deployment.php';
```

## Configuration
No configuration required.  

## Tasks

- `confirm-continue` – Requires user input to continue y/N (Default N)

## Usage

This automatically runs in the pre deploy tasks.

You can also add this task to your `deploy.php` script wherever confirmation is required:  

```
task('my-task', [
    ...
    'confirm-continue',    
    ...
]);
```
