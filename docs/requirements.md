# Requirements

## PHP
This package requires PHP 8.0 and later.

If you're working on a project that doesn't support PHP8 then use the [v1 release](https://github.com/studio24/deployer-recipes/tree/v1.1.0) (but please consider upgrading PHP first!).

## SSH access

The assumption is people can deploy to a webserver via SSH, therefore SSH access needs to be set up on the remote server in 
order to use Deployer.

We use the [ssh-keys](https://github.com/studio24/ssh-keys) repo to help manage staff public SSH keys and distribute these 
to client servers.

You can check SSH access works via:

```
dep check-ssh
```
