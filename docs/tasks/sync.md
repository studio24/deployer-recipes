# Sync down recipe

Sync files or folders down from the remote host to your local development environment (e.g. sync down live assets).

This task is simply called "sync" for convenience, since it is designed to be run on the command-line rather than included 
in a deployment recipe.

## Usage

Either [install all Studio 24 tasks](../installation.md) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/tasks/sync.php';
```

## Configuration

Requires the setting of
* _sync_ - array of files/folders to sync from remote to local

Array must be in format: name => [ remote path => local path]

E.g.

```php
set('sync', [
    'images' => [
        'shared/web/wp-content/uploads/' => 'web/wp-content/uploads'
    ],
]);
```

You can setup multiple sync paths.

### Remote path

The remote path is relative to the `deploy_path` (set in your hosts configuration). 

If you want to sync a folder from the current release, prefix with `current/`

If you want to sync a folder from a shared folder, prefix with `shared/`

### Local path

The local path is relative to your project root. 

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
'shared/storage/logs/error.log' => 'logs/error.log'
```

You can also specify a folder on your local path (you must include a trailing slash), the remote file will then be 
created in here:

```php
'shared/storage/logs/error.log' => 'logs/'
```

## Tasks

- `sync` – sync files or folders from the remote host to local development

## Usage

Sync from any environment configured to your local development environment. By default this runs the 
fisrt sync path setup in config.

```
vendor/bin/dep sync <environment>
```  

E.g.

```
vendor/bin/dep sync staging
```

You can pass the `--dry-run` option to output the files that will be synched (but not actually run the sync):

```
vendor/bin/dep sync staging --dry-run
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
vendor/bin/dep sync staging --files=log
```





