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

A sample of a full deploy file which runs composer install on deployment in the project root can be found in `examples/deploy-composer.php`
A sample of a full deploy file without running composer install in the project root can be found in `examples/deploy-non-composer.php`

To use these file in a project copy it to your project root and update the config variables. 

## Requirements

* PHP 7.2+
* [Composer](https://getcomposer.org/)
* [Deployer](https://deployer.org/) 6.8+

[LICENSE]: ./LICENSE
[license-badge]: https://img.shields.io/badge/license-MIT-blue.svg
