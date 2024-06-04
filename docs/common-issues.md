# Common issues

## git_ssh_command

If your webserver is using OpenSSH version older than v7.6, updating the code may fail with the error message
_unsupported option "accept-new"_. In this case, override the Git SSH command with:

```php
set('git_ssh_command', 'ssh');
```

You can return the version of the OpenSSH server via `sshd -V`

## Don't install Deployer globally

You should run Deployer via the locally installed Deployer in your project, to ensure you are using the
right version of Deployer for your project.

You can check if you have global Deployer installed via:

```
composer global show deployer/deployer
```

To remove any global installation run:

```
composer global remove deployer/deployer
sudo rm /usr/local/bin/dep
```

## Legacy date formats in Build summaries

We have encountered issues in some legacy projects where the Date/time format in the build summary is
```
20240415_094357
```
The file [tasks/show-summary.php](tasks/show-summary.md) now checks for both date formats to return the build summary.

## Fixing permission issues for deploy:writeable
When updating projects to use `release 2.0` of Deployer Recipes we have encountered issues wih the ```deploy:writeable``` and ```deploy:shared``` tasks failing to re-assign correct permissions.
For example 
```
task deploy:writable
[staging]  error  in writable.php on line 121:
[staging] run cd /data/var/www/HOSTNAME/staging/releases/3 && (setfacl -L  -m u:"apache":rwX -m u:deploy:rwX storage/app/public)
[staging] err setfacl: storage/app/: Operation not permitted
[staging] exit code 1 (General error)
ERROR: Task deploy:writable failed!
```

To fix this on a **staging** site we followed the below process:
* Renamed the shared dir with ```mv /data/var/www/HOSTNAME/staging/shared /data/var/www/HOSTNAME/staging/shared-original```
* Re-deploy ```./vendor/bin/dep deploy:prepare staging```
* This will recreate the required shared dirs, with the correct permissions
* This will lock the deployment, unlock with ```./vendor/bin/dep deploy:unlock staging```
* Copy any shared files required from the ```shared-original``` to the ```shared``` dir

### Check permissions
To check the permissions on the dir use ```getfacl /data/var/www/HOSTNAME/staging/shared/storage/app/```

If a sub-directory has permission issues and needs to be the same as its parent, eg.
Writable
```
/data/var/www/HOSTNAME/staging/shared/uploads
```
Non-writable
```
/data/var/www/HOSTNAME/staging/shared/uploads/2024
```
Then you can
```
cd /data/var/www/HOSTNAME/staging/shared/uploads/2024
setfacl -m m::rwx .
```

