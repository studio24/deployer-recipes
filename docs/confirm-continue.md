# Confirm deployment recipe

Simple recipe to ask confirmation from user before continuing with deployment.

## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/task/confirm-deployment.php';
```

## Configuration
No configuration required.  

## Tasks

- `s24:confirm-continue` – Requires user input to continue y/N (Default N)


## Usage

Add task to your `deploy.php` script whereever confirmation is required:  

```
task('deploy', [
    ...

    's24:confirm-deployment',    
    ...
]);
```
