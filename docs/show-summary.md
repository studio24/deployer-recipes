# Show summary recipe

Displays a human friendly summary of the current build information to preview what is currently deployed

## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/src/show-summary.php';
```

## Configuration
Creates a file containing:
* Current environment
* The current build date & time
* The currently deployed branch
* The Commit ID
* Who made the deployment

## Tasks

- `studio24:show-summary` – retrieves current deployment info and displays in the terminal

## Usage

Run on any environment to create the file   

```dep studio24:show-summary environment```  

eg:
```dep studio24:show-summary staging```  
  






