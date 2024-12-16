# Static site

Deploy a static site.

## Recipe

You can copy an example deployment file:

```
cp vendor/studio24/deployer-recipes/examples/static.php ./deploy.php
```

## Tasks

The static site recipe has 3 new tasks it runs:

### deploy:local_build

Checks out code from git to a local temporary folder and builds your website files. This runs a sub-task called `local_build` 
to run all the required website build commands.

You can control where the project is checked out from via `build_root`

### local_build

Builds static site. All commands run relative to the `build_path`.

We recommend you override this in your `deploy.php script`, e.g.

```php
task('local_build', function() {
    runLocally('composer install');
    runLocally('./vendor/bin/design-system');
});
```

Please note build commands run via [Symfony Process](https://symfony.com/doc/current/components/process.html) which runs each command in a sub-process.

Therefore, if you need to run commands that need to pass information to subsequent commands, use `&&` to join multiple commands into one command.

If you want to run NPM commands, you can use `runNpmLocally()`, which automatically prepends `nvm use` commands to run NPM via the correct version.

```php
task('local_build', function() {
    runNpmLocally('npm install');
    runNpmLocally('npm build');
});
```

### deploy:rsync

Rsyncs files from local to the remote server.

You need to define which local folder website files are built into via `build_folder`

You can control which remote folder files are synced to via `rsync_folder`  

## Configuration

### Required configuration

* `build_folder`: directory that contains built website files (e.g. `_dist`)

### Optional configuration

* `build_root`: root directory to store build files (default is `~/.deployer`)
* `rsync_folder`: directory to rsync files to, relative to release_path (default is nothing, so files are rsynched to release_path)
