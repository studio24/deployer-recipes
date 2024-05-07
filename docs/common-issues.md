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
