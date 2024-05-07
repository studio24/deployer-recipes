# Logs

Tasks to help you interrogate log files.

## Tasks

- [logs:list](#logslist) – List available log files
- [logs:view](#logsview) – View a log file
- [logs:search](#logssearch) - Search a log file
- [logs:download](#logsdownload) - Download a log file

## Installation

Either [install all Studio 24 tasks](../installation.md) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/tasks/logs.php';
```

## Configuration
Ensure you have set the `log_files` configuration variable in your `deploy.php` file. This can be a string (multiple values separated by a commma) or an array of log files.

E.g. 

```
set('log_files', '/data/logs/staging.studio24.net.access.log /data/logs/staging.studio24.net.error.log')
```

or:

```
set('log_files', [
    '/data/logs/staging.studio24.net.access.log',
    '/data/logs/staging.studio24.net.error.log',
    'storage/logs/*.log',
])
```

Please note by using this task you can specify `log_files` as a string or array safely, and it will continue to work with other Deployer log tasks (such as `dep log:app`).

## Usage

### logs:list

List available log files.

Example:

```
dep logs:list production
```


### logs:view

View a log file, options include:

* `--logfile=[LOGFILE]` The log file to view - you are asked to choose a file if you don't set this option
* `--lines=[LINES]` Number of lines to display - defaults to 20, 0 returns all lines

Example:

```
dep logs:view production
```

When you view a log file, if you don't specify a logfile as an option you'll be asked to choose from available log files.

You can either keep the logfile open for new entries and view the last entries. This uses `tail -f` to open the logfile for viewing. 
New entries will appear until you cancel the command with `Ctrl+C`.

Or you can specify the number of lines to view in the logfile. If you pass `0` then this displays all logfile lines.

### logs:search

Return matching lines from a log file, options include:

* `--logfile=[LOGFILE]` The log file to search - you are asked to choose a file if you don't set this option
* `--search=[SEARCH]` Only return lines that match the search string
* `--lines=[LINES]` Number of lines to display - defaults to 20, 0 returns all lines

Example:

```
dep logs:search production
```

### logs:download

Download a logfile to your local computer, options include:

* `--logfile=[LOGFILE]` The log file to download - you are asked to choose a file if you don't set this option 

Example:

```
dep logs:download production
```
