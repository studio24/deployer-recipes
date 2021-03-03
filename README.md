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

* [studio24:sync-down](docs/sync-down.md) - sync asset files from the remote host
* [studio24:build-summary](docs/build-summary.md) - create a _build_summary.json file

## Requirements

* PHP 7.2+
* [Composer](https://getcomposer.org/)
* [Deployer](https://deployer.org/) 6.8+

[LICENSE]: ./LICENSE
[license-badge]: https://img.shields.io/badge/license-MIT-blue.svg
