# Studio 24 Deployer recipes documentation 

At Studio 24 we use [Deployer](https://deployer.org/) to manage deployments of the majority of our client projects. This 
repo contains common settings and tasks we use on website projects.

## Installation

* [Installation](installation.md) - how to use Deployer for a project
* [Upgrading](upgrading.md) - how to upgrade from v1 to v2
* [Common settings and tasks](common.md) - common settings and tasks

## How to use Deployer

* [Usage](usage.md) - how to perform different tasks with Deployer

## Tasks

* [build-summary](tasks/build-summary.md) - create a `_build_summary.json` file to record deployment info
* [check-branch](tasks/check-branch.md) - ensure only default branch (main/master) is deployed to production
* [confirm-continue](tasks/confirm-continue.md) - ask confirmation from user before continuing with deployment
* [display-disk-space](tasks/display-disk-space.md) - display server disk usage prior to deployment
* [show-summary](tasks/show-summary.md) - display a summary of the current deployment info
* [vendors-subpath](tasks/vendors-subpath.md) - Run composer install in a sub-path
* [sync](tasks/sync.md) - sync files or folders from the remote host to local development

