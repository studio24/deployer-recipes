# Deployer recipes

Deployer recipes to aid deployment via https://deployer.org

[![license][license-badge]][LICENSE]

## Installation

Install via Composer:

```
composer require studio24/deployer-recipes --dev
```  

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

rather than:

```
dep deploy environment
```

If you wish, you can [install vendor binaries to another location](https://getcomposer.org/doc/articles/vendor-binaries.md#can-vendor-binaries-be-installed-somewhere-other-than-vendor-bin-)
by editing your project composer.json file. For example, to install to `bin` so you can run deployer via `bin/dep`: 

```json
{
  "config": {
    "bin-dir": "bin"
  }
}
```

## Tasks

The following tasks are available:

* [s24:build-summary](docs/build-summary.md) - create a `_build_summary.json` file to record deployment info
* [s24:check-branch](docs/check-branch.md) - ensure only default branch (main/master) is deployed to production
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

* PHP 7.2+
* [Composer](https://getcomposer.org/)
* [Deployer](https://deployer.org/) 6.8+

[LICENSE]: ./LICENSE
[license-badge]: https://img.shields.io/badge/license-MIT-blue.svg
