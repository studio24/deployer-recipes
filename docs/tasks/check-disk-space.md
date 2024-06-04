# Check disk space

Displays the disk usage of the remote server in the terminal
## Usage

Either [install all Studio 24 tasks](../installation.md) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/tasks/check-disk-space.php';
```

## Configuration

### disk_space_filesystem
If you set the filesystem mount this check can review disk capacity and warn if it is too low.

```
# AWS
set('disk_space_filesystem', '/data');

# Mythic Beasts
set('disk_space_filesystem', '/');
```

### disk_space_threshold

Set the disk space available (%) threshold to issue a disk space warning, by default this is 80.

### disk_space_max

Set the disk space available (%) threshold to halt deployment due to not enough server space, by default this is 97.

## Tasks

- `check:disk-space` – checks the disk usage of the target server and displays the results

## Usage

This automatically runs in the pre deploy tasks.

```
dep check:disk-space <environment>
```

Returns a summary of disk usage to the terminal (excluding temp drives) as below:

```
Filesystem      Size  Used Avail Use% Mounted on
/dev/nvme0n1p1  8.0G  4.0G  4.1G  50% /
/dev/nvme1n1     40G   27G   14G  68% /data
```

If you have set `disk_space_filesystem` a warning is displayed if the disk capacity is too low:

```
[production] Server disk space is almost full: 94% used
[production] Filesystem      Size  Used Avail Use% Mounted on
/dev/nvme1n1     40G   38G  2.8G  94% /data
```
