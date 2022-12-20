<?php

namespace Deployer;

require_once __DIR__ . '/show-summary.php';

desc('Slack notification on deploy to production');
task('s24:notify-slack', function () {
    $webhook = get('slack_webhook');
    $application = get('application');
    $user = runLocally('git config user.name');
    $branch = get('branch');
    $stage = get('stage');
    $buildSummaryUrl = rtrim(get('url'), '/') . '/_build_summary.json';

    $payload = [
        'text' => "*{$application}*: _{$user}_ deployed <{$buildSummaryUrl}|_{$branch}_> branch to _{$stage}_ :rocket:"
    ];
    $payload = json_encode($payload);

    $webhook = sprintf('curl -X POST --data-urlencode "payload=%s" %s', str_replace('"', '\"', $payload), $webhook);
    run($webhook);
    writeLn('Slack notification sent');
})->select('stage=production');

