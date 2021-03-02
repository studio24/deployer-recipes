# Sync up recipe

## Usage

[Install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'contrib/studio24/sync-down.php';
```

## Configuration

Requires the following variables to be set:
* $server_host = 'IP Address os server'; (eg: 49.129.3.92)
* $project_path = '/data/var/www/vhosts/site_name'; 
* $staging_url = 'https://staging.site_url';
* $production_url = 'https://live_site_url';
* $local_assets = 'local_path_relative_to_project_root'; (eg: web/wp-content/uploads)
* $shared = ('shared_path_on_server');(eg: /shared/web/wp-content/uploads) 


* set('hostip', $server_host );
* set('local_dir', $local_assets);
* set('remote_shared', $shared);

## Tasks

- `studio24:sync-down` – sync files (e.g. assets) from the remote host

## Usage

Usage notes and example code here





