# Confirm deployment recipe

Simple recipe to be included whereever a usr needs to confirm continuing

## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/src/confirm-deployment.php';
```

## Configuration
No configuration required.  

## Tasks

- `s24:confirm-deployment` – Requires user input to continue y/N (Default N)


## Usage

Add task to your `deploy.php` script whereever confirmation is required:  

```
task('deploy', [
    ...

    's24:confirm-deployment',    
    ...
]);
```
