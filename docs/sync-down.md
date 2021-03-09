# Sync down recipe

Sync files down from the remote host to your local development environment (e.g. sync down live assets).

## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/src/sync-down.php';
```

## Configuration

Requires the setting of
* The target host
* The local assets directory
* The remote assets directory


## Tasks

- `studio24:sync-down` – sync files (e.g. assets) from the remote host

## Usage

target added to each environment as part of host config
```php
host('production')
    ...
    
    ->set('target',$production_server)
    
    ...
```
Also set the remote and local asset paths
```
// Set with other variables
 $local_assets = 'web/wp-content/uploads';
 $$remote_assets = '/shared/web/wp-content/uploads';

// Sets the deployer variables
set('local_assets', $local_assets);
set('remote_assets', $remote_assets);
```
Sync from any environment configured to local machine   

```dep studio24:sync-down environment```  

eg:

```
dep studio24:sync-down staging

// @todo 
dep studio24:sync-down staging assets
```





