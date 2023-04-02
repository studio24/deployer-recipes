# Show summary recipe

Displays a human friendly summary of the current build information to preview what is currently deployed

## Usage

Either [install all Studio 24 tasks](../installation.md) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/tasks/show-summary.php';
```

## Configuration
No configuration is required.

## Tasks

- `show-summary` – retrieves current deployment info and displays in the terminal

## Usage
  
Run on any environment to display current deploy information   

```
dep show-summary <environment>
```  

eg:
```
dep show-summary production
```  

This returns a response detailing what is deployed to production.






