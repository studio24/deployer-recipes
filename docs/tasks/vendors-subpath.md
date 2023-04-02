# Vendors sub-path

Run composer install in a sub-path. This is useful if you have a composer.json file outside of the project root that 
you want to install on deployment.

## Usage

Either [install all Studio 24 tasks](../installation.md) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/tasks/vendors-subpath.php';
```

## Configuration
* _composer_paths_ - Array of sub-paths to run composer install in

E.g. 

```
set('composer_paths', ['web/wp-content/plugins/my-custom-plugin-folder']);
```

## Tasks

- `s24:vendors-subpath` – run composer install in a sub-path


## Usage

Add task to your `deploy.php` script:

```
task('deploy', [
    ...
    // Add before deploy:clear_paths
    's24:vendors-subpath',
    'deploy:clear_paths',
    ...
]);
```
