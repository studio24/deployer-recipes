# Sync down recipe

Sync files down from the remote host to your local development environment (e.g. sync down live assets).

## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/src/sync-down.php';
```

## Configuration

Requires the following variables to be set:
* _server_host_ = 'IP Address os server' (eg: 49.129.3.92)
* _project_path_ = '/data/var/www/vhosts/site_name' 
* _staging_url_ = 'https://staging.site_url'
* _production_url_ = 'https://live_site_url'
* _local_assets_ = 'local_path_relative_to_project_root' (eg: web/wp-content/uploads)
* _shared_ = ('shared_path_on_server') (eg: /shared/web/wp-content/uploads) 

Example:

```php
set('hostip', '49.129.3.92');
set('local_dir', 'todo');
set('remote_shared', 'todo');
```

## Tasks

- `studio24:sync-down` – sync files (e.g. assets) from the remote host

## Usage

Usage notes and example code here





