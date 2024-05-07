# Upgrading

## Upgrading to v2 (Deployer 7)

### Requirements

You need to ensure you are using PHP 8.0+

Update your composer.json file to use the v2.0 release:

```
composer require studio24/deployer-recipes:^2.0 --dev
```  
### Rename your old deploy.php file

The new deploy.php file is a lot simpler than the one we used with Deployer 6, so it's recommended to start from scratch using an example file.

It's recommended you rename your existing deployment file for reference:

```
cp deploy.php deploy.old.php
```

### Create a new deploy.php file

To get started copy an example deployment file (see [installation](installation.md#create-a-deployphp-file)).

General tips appear below.

### Recipe

You should only need to require once recipe file. You may want to add the [Slack](recipes/slack.md) recipe.

### Deployer settings

Update your `application`, `repository`, `disk_space_filesystem` settings.

If your old deploy script contains the [git_ssh_command](common-issues.md#git_ssh_command) setting, copy this across.

Check whether you need to add or override (via set) settings for `shared_files`, `shared_dirs`, `writable_dirs`, `remote_user`, `http_user`.

### Hosts

Copy the host settings across from your old deploy.php file. 

We used to create variables to store host settings, so you'll need to copy the values directly into the set() function call.

Remember to remove `http_user` if you are not using PHP-FPM.

### Deployment tasks

Check if you need to add any custom tasks. Chances are, the standard deployment tasks will be taken care of by your recipe and you don't need to anything here.

Check whether your old deploy script contains `composer_paths` and if so copy this across along with the task to run [Composer in a sub-path](installation.md#composer-in-sub-paths). 

Setting:

````php
// Custom (non-root) composer installs required
set('composer_paths', [
    'web/wp-content/plugins/s24-wp-image-optimiser'
]);
````

Task:

```
// Custom (non-root) composer installs
after('deploy:prepare', 'vendors-subpath');
```



### A note on release numbers

Release numbers reset in v7, if you want to retain the same release numbers first find out the current release, then
on your first deployment using Deployer 7 manually set the release number. E.g. to set the next release to 42:

```
./vendor/bin/dep deploy staging -o release_name=42
```

See [Deployer upgrade docs](https://deployer.org/docs/7.x/UPGRADE#step-2-deploy)

### Test a deployment

Can you connect via SSH?

```
dep check:ssh
```

Can you view the current deployment info?

```
dep show staging
```

Can you deploy to staging?

```
dep deploy staging
```

### Clean up

Remove your old v1 deployment file:

```
rm deploy.old.php
```

## Removed

* Removed the custom task s24:check-local-deployer and replaced this with clear documentation on how to use Deployer via Composer. 
* Removed the custom task s24:notify-slack since we can use the standard Slack contrib task in Deployer.
