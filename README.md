# Robo System Package Tasks

[![License](https://img.shields.io/packagist/l/falc/robo-system-package.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/Falc/RoboSystemPackage.svg?style=flat-square)](https://travis-ci.org/Falc/RoboSystemPackage)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/Falc/RoboSystemPackage.svg?style=flat-square)](https://scrutinizer-ci.com/g/Falc/RoboSystemPackage/)
[![Quality Score](https://img.shields.io/scrutinizer/g/Falc/RoboSystemPackage.svg?style=flat-square)](https://scrutinizer-ci.com/g/Falc/RoboSystemPackage/)

Collection of tasks for interacting with system package managers.

## Requirements

+ [Robo](http://robo.li/) ~0.5 (0.5.0 or higher)

## Installation

Add the `falc/robo-system-package` package to your `composer.json`:

```
composer require falc/robo-system-package
```

Add the `Falc\Robo\Package\loadTasks` trait to your `RoboFile`:

```php
class RoboFile extends \Robo\Tasks
{
    use Falc\Robo\Package\loadTasks;

    // ...
}
```

## Tasks

### Install

Installing a single package:

```php
$this->taskPackageInstall()
    ->packageManager('yum')
    ->package('package1')
    ->run();
```

Installing many packages:

```php
$this->taskPackageInstall()
    ->packageManager('yum')
    ->packages(['package1', 'package2'])
    ->run();
```

Compact form:

```php
$this->taskPackageInstall('yum', ['package1', 'package2'])->run();
```

It allows to specify packages conditionally:

```php
$install = $this->taskPackageInstall('yum', ['package1']);

if ($requiresPackage2) {
    $install->package('package2');
}

$install->run();
```

It is possible to specify a pattern:

```php
$this->taskPackageInstall()
    ->packageManager('yum')
    ->package('package1-*') // Installs all packages starting with "package1-"
    ->run();
```

You can combine it with `taskSshExec()` to install packages in a remote server:

```php
$installTask = $this->taskPackageInstall()
    ->packageManager('yum')
    ->packages(['package1', 'package2']);

$this->taskSshExec('remote.example.com')
    ->remoteDir('/home/user')
    ->printed(false) // Do not display output
    ->exec($installTask)
    ->run();
```

### Uninstall

Uninstalling a single package:

```php
$this->taskPackageUninstall()
    ->packageManager('yum')
    ->package('package1')
    ->run();
```

Uninstalling many packages:

```php
$this->taskPackageUninstall()
    ->packageManager('yum')
    ->packages(['package1', 'package2'])
    ->run();
```

Compact form:

```php
$this->taskPackageUninstall('yum', ['package1', 'package2'])->run();
```

It is possible to specify a pattern:

```php
$this->taskPackageUninstall()
    ->packageManager('yum')
    ->package('package1-*') // Uninstalls all packages starting with "package1-"
    ->run();
```

You can combine it with `taskSshExec()` to uninstall packages from a remote server:

```php
$uninstallTask = $this->taskPackageUninstall()
    ->packageManager('yum')
    ->packages(['package1', 'package2']);

$this->taskSshExec('remote.example.com')
    ->remoteDir('/home/user')
    ->printed(false) // Do not display output
    ->exec($uninstallTask)
    ->run();
```

### Update

Updating a single package:

```php
$this->taskPackageUpdate()
    ->packageManager('yum')
    ->package('package1')
    ->run();
```

Updating many packages:

```php
$this->taskPackageUpdate()
    ->packageManager('yum')
    ->packages(['package1', 'package2'])
    ->run();
```

Do not specify any package in order to perform a full update:

```php
$this->taskPackageUpdate()
    ->packageManager('yum')
    ->run();
```

Compact form:

```php
// Update some packages
$this->taskPackageUpdate('yum', ['package1', 'package2'])->run();

// Update everything
$this->taskPackageUpdate('yum')->run();
```

It is possible to specify a pattern:

```php
$this->taskPackageUpdate()
    ->packageManager('yum')
    ->package('package1-*') // Updates all packages starting with "package1-"
    ->run();
```

You can combine it with `taskSshExec()` to update packages in a remote server:

```php
$updateTask = $this->taskPackageUpdate()
    ->packageManager('yum')
    ->packages(['package1', 'package2']);

$this->taskSshExec('remote.example.com')
    ->remoteDir('/home/user')
    ->printed(false) // Do not display output
    ->exec($updateTask)
    ->run();
```

## Methods

All the tasks implement these methods:
 * `packageManager($packageManager)`: Sets the package manager to use.
 * `package()`: Adds a package to the package list.
 * `packages()`: Adds packages to the package list.
 * `verbose()`: Enables the verbose mode.

## Package managers

Every task requires to set a package manager either in the constructor or using the `packageManager($packageManager)` method.

At the moment these are the supported package managers:
* [apt](https://wiki.debian.org/Apt)
* [dnf](http://dnf.readthedocs.org/)
* [pacman](https://wiki.archlinux.org/index.php/Pacman)
* [yum](https://fedoraproject.org/wiki/Yum)
