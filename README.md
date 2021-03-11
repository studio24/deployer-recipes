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
* [s24:disk-usage](docs/check-disk-space.md) - display server disk usage prior to deployment
* [s24:confirm](docs/confirm-continue.md) - ask confirmation from user before continuing with deployment
* [s24:show-summary](docs/show-summary.md) - display a summary of the current deployment info
* [s24:sync-down](docs/sync-down.md) - sync asset files from the remote host
* [s24:wordpress-install](docs/wordpress-install.md) - installs WordPress in /web/ if not included in source control

## Requirements

* PHP 7.2+
* [Composer](https://getcomposer.org/)
* [Deployer](https://deployer.org/) 6.8+

[LICENSE]: ./LICENSE
[license-badge]: https://img.shields.io/badge/license-MIT-blue.svg
