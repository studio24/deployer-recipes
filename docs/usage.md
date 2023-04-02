# Usage

How to perform different tasks with Deployer.

* [Installing Deployer](#installing-deployer)
* [Deployment](#deployment)
* [Rolling back a deployment](#rolling-back-a-deployment)
* [Viewing remote logfiles](#viewing-remote-logfiles)
* [Synching files to local dev](#synching-files-to-local-dev)
* [SSHing to a remote server](#sshing-to-a-remote-server)

## Installing Deployer

Run Composer install to load the required PHP packages:

```
composer install
```

You can then run Deployer via `./vendor/bin/dep`

You can create a shortcut to your local Deployer by adding an alias to your `~/.zshrc` or `~/.nvmrc` file:

```
alias dep='vendor/bin/dep'
```

You can then run `dep` instead of `./vendor/bin/dep` (which is the format we use in examples below).

### Global Deployer

You should run Deployer via the locally installed Deployer in your project, to ensure you are using the
right version of Deployer.

You can check if you have global Deployer installed via:

```
composer global show deployer/deployer
```

To remove any global installation run:

```
composer global remove deployer/deployer
sudo rm /usr/local/bin/dep
```

## Deployment

To run deployments use:

```
dep deploy <environment> --branch=<branch name> 
```

E.g. to deploy the `feature/new-thing` branch to staging:

```
dep deploy staging --branch=feature/new-thing 
```

To deploy the main (default) branch to production:

```
dep deploy production 
```

Please note you can only deploy the default branch to production (usually main), you can override this behaviour by 
passing the `--force` option.

## Rolling back a deployment

Rollback to the last deployment via:

```
dep rollback <environment>
```

E.g. to rollback production to the last release:

```
dep rollback production
```

## Viewing remote logfiles

Deployer defines application logfiles in the `log_files` configuration setting. This can be one or multiple log files.

View the last 10 lines of log files via:

```
dep logs:app <environment>
```

E.g.

```
dep logs:app staging
```

## Synching files to local dev


## SSHing to a remote server