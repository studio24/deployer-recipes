# Sync down recipe

Sync files or folders down from the remote host to your local development environment (e.g. sync down live assets).

This task is simply called "sync" for convenience, since it is designed to be run on the command-line rather than included 
in a deployment recipe.

## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/src/sync.php';
```

## Configuration

Requires the setting of
* _sync_ - array of files/folders to sync from remote to local

Array must be in format: name => [ remote path => local path]

E.g.

```php
$sync = [
    'images' => [
        'shared/web/wp-content/uploads/' => 'web/wp-content/uploads'
    ]
];
set('sync', $sync);
```

You can setup multiple sync paths.

## Synching files or folders

This task can sync both files or folders. To sync a folder it is important to add a trailing slash 
to the remote path name and do not do this for the local path name. This will then copy folder to folder.

E.g.

```php
'shared/web/wp-content/uploads/' => 'web/wp-content/uploads'
```

If you forget the trailing slash on the remote path it will create a sub-folder in your local path.

To sync files, you can specify the filename in remote and local:

```php
'var/log/error.log' => 'logs/error.log'
```

You can also specify a folder on your local path (you must include a trailing slash), the remote file will then be 
created in here:

```php
'var/log/error.log' => 'logs/'
```

## Tasks

- `sync` – sync files or folders from the remote host to local development

## Usage

Sync from any environment configured to your local development environment. By default this runs the 
fisrt sync path setup in config.

```
dep sync <environment>
```  

E.g.

```
dep sync staging
```

To sync different file paths, you can use the `--files` option. For example, to sync down a logfile setup the config 
could look like:

```php
$sync = [
    'images' => [
        'shared/web/wp-content/uploads/' => 'web/wp-content/uploads'
    ],
    'log' => [
        'var/log/error.log' => 'logs/error.log'
    ]
];
set('sync', $sync);
```

And the sync command would be:

```
dep sync staging log
```





