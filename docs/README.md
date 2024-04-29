# Studio 24 Deployer recipes documentation 

This package contains [Deployer](https://deployer.org/) recipes used to help deploy Studio 24 projects.

## Installation

* [Installation](installation.md) - how to use Deployer for a project
* [Upgrading](upgrading.md) - how to upgrade from v1 (Deployer 6) to v2 (Deployer 7)

## How to use Deployer

* [Usage](usage.md) - how to perform different tasks with Deployer
* [Common issues](common-issues.md) - common issues and how to resolve them 

## Recipes

* Default
* Craft CMS
* Laravel
* Symfony
* WordPress

## Tasks

* [build-summary](tasks/build-summary.md) - create a `_build_summary.json` file to record deployment info
* [check-branch](tasks/check-branch.md) - ensure only default branch (main/master) is deployed to production
* [check-ssh](tasks/check-ssh.md) - check SSH connection to remote server
* [confirm-continue](tasks/confirm-continue.md) - ask confirmation from user before continuing with deployment
* [display-disk-space](tasks/display-disk-space.md) - display server disk usage prior to deployment
* [show-summary](tasks/show-summary.md) - display a summary of the current deployment info
* [sync](tasks/sync.md) - sync files or folders from the remote host to local development
* [vendors-subpath](tasks/vendors-subpath.md) - Run composer install in a sub-path
