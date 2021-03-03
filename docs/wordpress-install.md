# Wordpress install recipe

Installs a copy or Wordpress for projects that do not contain Wordpress in version control.

## Usage

Either [install all Studio 24 tasks](../README.md#installation) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/src/wordpress-install.php';
```

## Configuration

```
todo
```

## Tasks

- `studio24:wordpress-install` – Installs Wordpress to the path web/Wordpress

## Usage

Install Wordpress on the webserver   

```dep studio24:wordpress-install environment```  

eg:
```dep studio24:wordpress-install staging```





