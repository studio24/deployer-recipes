# Deployer recipes

Deployer recipes to aid deployment via https://deployer.org

[![license][license-badge]][LICENSE]

## Installation

### Deployer 7
Install via Composer (this loads Deployer v7):

```
composer require studio24/deployer-recipes:^2.0 --dev
```  

### Deployer 6
If you need to use Deployer v6 please use:

```
composer require studio24/deployer-recipes:^1.1 --dev
```

### Configuration

Install all Studio 24 Deployer tasks by adding this to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/all.php';
```

To only install individual tasks, see the docs for each task.

### Running Deployer

Please note this project uses a local Deployer installation (via Composer) not a global version of Deployer. This is so we
can make use of other Composer packages in deployment tasks reliably.

To run deployments please use:

```
vendor/bin/dep deploy environment 
```

You can also create a shortcut to your local Deployer by adding an alias to your `.nvmrc` file:

```
alias dep='vendor/bin/dep'
```

You can then run `dep` instead of `vendor/bin/dep`

### If you have a global Deployer installed

We recommend you do not use global Deployer to avoid any clashes with different Deployer versions. To remove any global installation run:

```
composer global remove deployer/deployer
```

## Tasks

The following tasks are available:

* [s24:build-summary](docs/build-summary.md) - create a `_build_summary.json` file to record deployment info
* [s24:check-branch](docs/check-branch.md) - ensure only default branch (main/master) is deployed to production
* [s24:check-local-deployer](docs/check-local-deployer.md) - checks that deployment is running via the local Deployer install
* [s24:confirm-continue](docs/confirm-continue.md) - ask confirmation from user before continuing with deployment
* [s24:display-disk-space](docs/display-disk-space.md) - display server disk usage prior to deployment
* [s24:notify-slack](docs/notify-slack.md) - send a notification to Slack on production deploy  
* [s24:show-summary](docs/show-summary.md) - display a summary of the current deployment info
* [s24:vendors-subpath](docs/vendors-subpath.md) - Run composer install in a sub-path
* [sync](docs/sync.md) - sync files or folders from the remote host to local development

## Full deploy example

A sample of a full deploy file can be found in `examples/deploy.php`

To use this file in a project copy it to your project root and update the config variables.

Please edit `deploy.php` depending on your needs. For example if you don't need to run Composer during deployment remove the line: 

```    
    // Composer install
    'deploy:vendors,',
```

## Requirements

* PHP 7.4+ (Deployer 6)
* PHP 8.0+ (Deployer 7)
* [Composer](https://getcomposer.org/)
* [Deployer](https://deployer.org/) 

[LICENSE]: ./LICENSE
[license-badge]: https://img.shields.io/badge/license-MIT-blue.svg
