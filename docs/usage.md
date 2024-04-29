# Usage

How to perform different tasks with Deployer.

* [Show what was last deployed](#show-what-was-last-deployed)
* [Deploying](#deploying)
* [Rolling back](#rolling-back)
* [Viewing logfiles](#viewing-logfiles)
* [Synching files](#synching-files)
* [SSH to a remote server](#ssh-to-a-remote-server)

## Show what was last deployed

To view what was last deployed to an environment:

```
dep show-summary <environment>
```

E.g. 

```
dep show-summary staging
```

## Deploying

To run a deployment:

```
dep deploy <environment>
```

By default, this will deploy to the default branch (main / master).

E.g.

```
dep deploy production
```

To specify a branch use:

```
dep deploy <environment> --branch=<branch name>
```

E.g. 

```
dep deploy staging --branch=feature/new-thing 
```

Please note you cannot deploy non-default branches to production unless you pass the `--force` option.

If you want to find out what tasks run for a deployment:

```
dep tree deploy
```

## Rolling back

Rollback to the last deployment via:

```
dep rollback <environment>
```

E.g. to rollback production to the last release:

```
dep rollback production
```

## Viewing logfiles

Deployer defines application logfiles in the `log_files` configuration setting. This can be one or multiple log files.

View the last 10 lines of log files via:

```
dep logs:app <environment>
```

E.g.

```
dep logs:app staging
```

## Synching files

To sync files locally you need to setup sync settings in your `deploy.php` file.

You can run sync via:

```
dep sync <name>
```

E.g.

```
dep sync images
```

If you only have one sync setup, or you want to run the first sync task, then you don't need to pass a name.

See [sync documentation](tasks/sync.md).

## SSH to a remote server

Connect to a remote server via:

```php
dep ssh <environment>   
```

E.g. to connect to staging:

``` 
dep ssh staging
```
