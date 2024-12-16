# Static site

Deploy a static site.

## Recipe

You can copy an example deployment file:

```
cp vendor/studio24/deployer-recipes/examples/static.php ./deploy.php
```

## Configuration

### Required configuration

* `build_commands`: array of build commands to run on build files
* `build_folder`: directory that contains built website files (e.g. `_dist`)
 
Please note build commands run via Symfony Process which runs each command in a sub-process. 

If you need to run NVM and NPM you should create a single line command as so:

```
set('build_commands', [
    'source ~/.nvm/nvm.sh && nvm use && npm install && npm run build',
]);
```

### Optional configuration

* `build_root`: root directory to store build files (default is `~/.deployer`)
* `rsync_folder`: directory to rsync files to, relative to release_path (default is nothing, so files are rsynched to release_path)
* 