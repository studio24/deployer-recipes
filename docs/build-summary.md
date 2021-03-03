# Build summary recipe

Creates a summary of current build information to preview what is currently deployed

## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/src/build-summary.php';
```

## Configuration
Creates a file containing:
* Current environment
* The current build date & time
* The currently deployed branch
* The Commit ID
* Who made the deployment

## Tasks

- `studio24:build-summary` – retrieves current deployment info and create a _build_summary.json file

## Usage

Run on any environment to create the file   

```dep studio24:build-summary environment```  

eg:
```dep studio24:build-summary staging```  
  
view the file by adding the name to the URI  
```https://website_url/_build_summary.json```





