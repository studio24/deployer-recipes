# Sync down recipe

Sync files down from the remote host to your local development environment (e.g. sync down live assets).

## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/src/sync-down.php';
```

## Configuration

Requirements

```php
set('hostip', '49.129.3.92');
set('local_dir', 'web/wp-content/uploads');
set('remote_shared', '/shared/web/wp-content/uploads');
```

## Tasks

- `studio24:sync-down` – sync files (e.g. assets) from the remote host

## Usage

Sync from any environment configured to local machine   

```dep studio24:sync-down environment```  

eg:

```
dep studio24:sync-down staging

// @todo 
dep studio24:sync-down staging assets
```





