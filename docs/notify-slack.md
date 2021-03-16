# Notify Slack

Send a notification to Slack on production deploy. **Please note** this task only runs on the production environment.

## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/src/notify-slack.php';
```

## Configuration
* _slack_webhook_ - Slack webhook to send notifications to

E.g. 

```
set('slack_webhook', 'https://hooks.slack.com/services/ABC123/ABC123/abc678de');
```

## Tasks

- `s24:notify-slack` – send a notification to Slack on production deploy


## Usage

It's recommended to add Slack notification to `deploy.php` after a successful deployment:  

```
// Slack notification
after('success', 's24:notify-slack');
```
