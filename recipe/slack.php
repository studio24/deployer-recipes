<?php

namespace Deployer;

require_once 'contrib/slack.php';

/**
 * Common setup for Slack notifications
 */

// Slack notification configuration
set('slack_text', '_{{user}}_ deploying `{{target}}` to *{{alias}}*');
set('slack_success_text', 'Deploy `{{target}}` to *{{alias}}* successful :rocket:');
set('slack_failure_text', 'Deploy `{{target}}` to *{{alias}}* failed');

// Notify Slack on deployment
after('check-branch', 'slack:notify');
after('deploy:success', 'slack:notify:success');
after('deploy:failed', 'slack:notify:failure');
