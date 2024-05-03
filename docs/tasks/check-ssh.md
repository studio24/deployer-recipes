# Check SSH connection recipe

Checks your SSH connection works.

## Usage

Either [install all Studio 24 tasks](../installation.md) or install this individual task by adding to your `deploy.php`:

```php
require 'vendor/studio24/deployer-recipes/tasks/check-ssh.php';
```

## Configuration
No configuration required

## Tasks

- `check:ssh` – checks your SSH connection to the remote server

## Usage

```
dep check:ssh <environment>
```

E.g.

```
dep check:ssh staging
```
