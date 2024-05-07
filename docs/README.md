# Studio 24 Deployer recipes documentation 

This package contains [Deployer](https://deployer.org/) recipes used to help deploy Studio 24 projects.

## Installation

* [Installation](installation.md) - how to use Deployer for a project
* [Upgrading](upgrading.md) - how to upgrade from v1 (Deployer 6) to v2 (Deployer 7)

## How to use Deployer

* [Usage](usage.md) - how to perform different tasks with Deployer
* [Common issues](common-issues.md) - common issues and how to resolve them 

## Recipes

* [Slack](recipes/slack.md) - send a notification to Slack when a deployment is complete

## Deployment tasks

* [build-summary](tasks/build-summary.md) - create a `_build_summary.json` file to record deployment info
* [check:branch](tasks/check-branch.md) - ensure only default branch (main/master) is deployed to production
* [check:disk-space](tasks/check-disk-space.md) - display server disk usage prior to deployment
* [confirm-continue](tasks/confirm-continue.md) - ask confirmation from user before continuing with deployment
* [show](tasks/show-summary.md) - display a summary of the current deployment info
* [vendors-subpath](tasks/vendors-subpath.md) - Run composer install in a sub-path

## Utility tasks

* [check:disk-space](tasks/check-disk-space.md) - display server disk usage prior to deployment
* [check:ssh](tasks/check-ssh.md) - check SSH connection to remote server
* [logs:list](tasks/logs.md) - list available log files
* [logs:view](tasks/logs.md) - view a log file
* [logs:search](tasks/logs.md) - search a log file
* [logs:download](tasks/download.md) - download a log file
* [show](tasks/show-summary.md) - display a summary of the current deployment info 
* [sync](tasks/sync.md) - sync files or folders from the remote host to local development
