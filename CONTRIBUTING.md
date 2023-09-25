# How to contribute

Deployer Recipes is released under the MIT license and is copyright [Studio 24 Ltd](https://www.studio24.net/). All contributors
must accept these license and copyright conditions.

## Organising code

New tasks must be added to the `tasks/` folder and required in the [`recipe/common.php`](all.php) file to ensure it is available for 
users who load all Studio 24 Deployer tasks.

## Code must be standalone

From v7 Deployer is distributed in a Phar file, which means you cannot use additional Composer packages in your recipes. 

## Pull Requests

All contributions must be made on a branch and must pass coding standards.

Please create a Pull Request to merge changes into master, these will be automatically tested by
[GitHub Actions](https://github.com/studio24/deployer-recipes/actions/workflows/php.yml).

All Pull Requests need at least one approval from the Studio 24 development team.

## Release

We follow [semantic versioning](https://semver.org/). This can be summarised as:

* MAJOR version when you make incompatible API changes (e.g. 1.0.0)
* MINOR version when you add functionality in a backwards compatible manner (e.g. 1.1.0)
* PATCH version when you make backwards compatible bug fixes (e.g. 1.1.1)

### Creating a release

To create a new release do the following:

1. Ensure any new tasks have documentation in the `docs/` folder detailing usage
1. Create a [new release](https://help.github.com/en/github/administering-a-repository/managing-releases-in-a-repository)
   at GitHub. This will automatically create a new release at [Packagist](https://packagist.org/packages/studio24/deployer-recipes)
   so code can be loaded via Composer.

