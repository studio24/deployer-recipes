# Slack

Add the Slack recipe to send notifications to a Slack channel on deployment. 
This contains some predefined settings to make it easier to send notifications to Slack.

#### Recipe

```
require 'vendor/studio24/deployer-recipes/recipe/slack.php';
```

#### Configuration
You need to set up a [Slack webhook URL](https://api.slack.com/messaging/webhooks) and save this as an environment variable in your `.env` file:

`.env` file:

```
SLACK_WEBHOOK=https://hooks.slack.com/services/your/webhook/url
```

In your `deploy.php` you need to load environment variables:

```
set('dotenv', '{{current_path}}/.env');
```

You can also set this in your `deploy.php` script instead of an environment variable, but this is not recommended since it contains sensitive information.

```
set('slack_webhook', 'https://hooks.slack.com/services/your/webhook/url');
```
