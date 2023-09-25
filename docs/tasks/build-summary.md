# Build summary recipe

Creates a summary of current build information to preview what is currently deployed.

## Usage

Either [install all Studio 24 tasks](../installation.md) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/tasks/build-summary.php';
```

## Configuration
You need to ensure webroot is set in your `deploy.php` file.

## Tasks

- `build-summary` – retrieves current deployment info and creates a `_build_summary.json` file in the web root

## Usage

This automatically runs after deploy:publish and creates a JSON file containing:
* 
* Current environment
* The current build date & time
* The currently deployed branch
* The commit ID
* Who made the deployment

Example:

```json
{
  "environment": "staging",
  "buildDateTime": "20210303_163358",
  "gitBranch": "hotfix\/101-update-team",
  "commitId": "01543dac170435769afa6ab90ef838d0c3001ac5",
  "deployedBy": "Alan Isaacson (alan@studio24.net)"
}
```
