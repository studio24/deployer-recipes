# Deployer recipes

This package contains [Deployer](https://deployer.org/) recipes used to help deploy Studio 24 projects.   

[![license][license-badge]][LICENSE]

## Requirements

* PHP 8.0+ (Deployer 7)
* PHP 7.2 (Deployer 6)
* [Composer](https://getcomposer.org/)

## Documentation

View [documentation](docs/README.md).

If you want to contribute to this project, please read the [contribution guidelines](CONTRIBUTING.md).

## Installation

### Deployer 7 (PHP 8.0+)

Install via Composer:

```
composer require studio24/deployer-recipes:^2.0 --dev
```  

See [installation instructions](docs/installation.md).

### Deployer 6 (PHP 7.2–7.4)

Install via Composer:

```
composer require studio24/deployer-recipes:^1.1 --dev
```

See [installation instructions](https://github.com/studio24/deployer-recipes/tree/v1.1.0).

## Running Deployer

To run deployments use:

```
dep deploy <environment> --branch=<branch name> 
```

See [usage documentation](docs/usage.md).


[LICENSE]: ./LICENSE
[license-badge]: https://img.shields.io/badge/license-MIT-blue.svg
