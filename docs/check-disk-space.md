# Check branch recipe

Displays the disk usage of the remote server in the terminal
## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/src/check-disk-space.php';
```

## Configuration
No configuration required

## Tasks

- `s24:check-disk-space` – checks the disk usage of the target server and displays the results


## Usage

Add task to your `deploy.php` script:  
**Note:** it is suggested to use in conjunction with [confirm deployemnt](confirm-deployment.md)

```
task('deploy', [
    ...
    // Add after deploy:info
    'deploy:info',

    's24:check-drive-space',
    's24:confirm',    
    ...
]);
```

Returns a summary of disk usage to the terminal as below 
```
Filesystem      Size  Used Avail Use% Mounted on
devtmpfs        962M     0  962M   0% /dev
tmpfs           979M     0  979M   0% /dev/shm
tmpfs           979M   27M  953M   3% /run
tmpfs           979M     0  979M   0% /sys/fs/cgroup
/dev/nvme0n1p1  8.0G  4.0G  4.1G  50% /
/dev/nvme1n1     40G   27G   14G  68% /data
tmpfs           196M     0  196M   0% /run/user/0
tmpfs           196M     0  196M   0% /run/user/5000✔ Ok
```
