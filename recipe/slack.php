<?php

namespace Deployer;

require_once 'contrib/slack.php';

// Extend the Slack recipe with our common setup

// Slack webhook
if (getenv('SLACK_WEBHOOK') !== false) {
    set('slack_webhook', getenv('SLACK_WEBHOOK'));
}

// Slack notification configuration
set('slack_text', '_{{user}}_ deploying `{{target}}` to *{{alias}}*');
set('slack_success_text', 'Deploy `{{target}}` to *{{alias}}* successful :rocket:');
set('slack_failure_text', 'Deploy `{{target}}` to *{{alias}}* failed');

// Notify Slack on deployment
after('check-branch', 'slack:notify');
after('deploy:success', 'slack:notify:success');
after('deploy:failed', 'slack:notify:failure');
