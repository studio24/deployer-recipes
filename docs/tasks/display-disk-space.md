# Check branch recipe

Displays the disk usage of the remote server in the terminal
## Usage

Either [install all Studio 24 tasks](../installation.md) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/tasks/display-disk-space.php';
```

## Configuration
No configuration required

## Tasks

- `display-disk-space` – checks the disk usage of the target server and displays the results

## Usage

This automatically runs in the pre deploy tasks.

Returns a summary of disk usage to the terminal (excluding temp drives) as below:

```
Filesystem      Size  Used Avail Use% Mounted on
/dev/nvme0n1p1  8.0G  4.0G  4.1G  50% /
/dev/nvme1n1     40G   27G   14G  68% /data
```
