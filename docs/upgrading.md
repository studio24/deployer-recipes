# Updrading

## Upgrading to Deployer 7 (v2.0 of deployer-recipes)

See full [installation instructions](installation.md).

### Example file

It's recommended you rename your existing deployment file for reference:

```
cp deploy.php deploy.v1.php
```

You can then copy the new example deployment file:

```
cp vendor/studio24/deployer-recipes/examples/deploy.php ./deploy.php
```

### Recipe

Replace: 

```php
require 'vendor/studio24/deployer-recipes/all.php';
```

with:

```php
require 'vendor/studio24/deployer-recipes/common.php';
```

### Configuration

Change how configuration is set up, from using variables such as:

```php
$project_name = 'Studio 24 website';
```

To using the set functions directly:

```php
set('application', 'Studio 24 website');
```

Remove configuration settings for:
* remote_user
* http_user

Unless they differ from that used in [common.php](../common.php)

Remove configuration settings for:
* keep_releases (unless you want to change it from the Deployer default of 10)

Remove old config settings no longer used:
* git_tty
* allow_anonymous_stats
* default_stage

Please note we set the DO_NOT_TRACK environment variable in common.php to disable telemetry.

### Hosts

Simplify host setup:
* Environment should be set as the host value (the host alias)
* Remove stage
* Remove user
* Add log_files setting to enable users to view log files via `dep logs:app production`

Example:

```php
host('production')
    ->set('hostname', '63.34.69.8')
    ->set('deploy_path', '/data/var/www/vhosts/studio24.net/production')
    ->set('log_files', '/data/logs/studio24.net.access.log /data/logs/studio24.net.error.log')
    ->set('url', 'https://www.studio24.net');
```

You can set log_files to one file, multiple files, or use * to pattern match valid log files (e.g. storage/logs/*.log)

### Deployment tasks

Remove all custom deployment tasks. 

Where possible, use a default Deployer recipe and set custom tasks via before and after if these are required.

See [examples](../examples).

### A note on release numbers

Release numbers reset in v7, if you want to retain the same release numbers first find out the current release, then
on your first deployment using Deployer 7 manually set the release number. E.g. to set the next release to 42:

```
./vendor/bin/dep deploy staging -o release_name=42
```

See [upgrade docs](https://deployer.org/docs/7.x/UPGRADE#step-2-deploy)

### Test a deployment

Can you connect via SSH?

```
./vendor/bin/dep ssh
```

Can you deploy to staging?

```
./vendor/bin/dep deploy staging
```

### Clean up

Remove your old v1 deployment file:

```
rm deploy.v1.php
```

## Removed

* Removed the custom task s24:check-local-deployer and replaced this with clear documentation on how to use Deployer via Composer. 
* Removed the custom task s24:notify-slack since we can use the standard Slack contrib task in Deployer.