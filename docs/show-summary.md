# Show summary recipe

Displays a human friendly summary of the current build information to preview what is currently deployed

## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/src/show-summary.php';
```

## Configuration
No configuration is required.

## Tasks

- `studio24:show-summary` – retrieves current deployment info and displays in the terminal

## Usage
  
Run on any environment to create the file   

```dep studio24:show-summary environment```  

eg:
```dep studio24:show-summary production```  

This returns a response of

```angular2html
Build Summary:
 
Currently deployed branch on the production environment is master, deployed on Wednesday, March 03 at 04:54PM by Alan Isaacson (alan@studio24.net).

```





