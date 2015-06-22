<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package;

use Falc\Robo\Package\BaseTask;
use Robo\Contract\CommandInterface;

/**
 * Package Install
 *
 * ``` php
 * // Installing a single package:
 * $this->taskPackageInstall()
 *     ->packageManager('yum')
 *     ->package('package1')
 *     ->run();
 *
 * // Installing many packages:
 * $this->taskPackageInstall()
 *     ->packageManager('yum')
 *     ->packages(['package1', 'package2'])
 *     ->run();
 *
 * // Compact form:
 * $this->taskPackageInstall('yum', ['package1', 'package2'])->run();
 *
 * // It allows to specify packages conditionally:
 * $install = $this->taskPackageInstall('yum', ['package1']);
 *
 * if ($requiresPackage2) {
 *     $install->package('package2');
 * }
 *
 * $install->run();
 *
 * // It is possible to specify a pattern:
 * $this->taskPackageInstall()
 *     ->packageManager('yum')
 *     ->package('package1-*') // Installs all packages starting with "package1-"
 *     ->run();
 * ```
 */
class Install extends BaseTask implements CommandInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        if ($this->builder === null) {
            throw new \Exception('Package manager not defined');
        }

        $this->builder->install($this->packages)->assumeYes();

        if (!$this->verbose) {
            $this->builder->quiet();
        }

        return $this->builder->getCommand();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $command = $this->getCommand();

        $this->printTaskInfo('Installing packages...');
        return $this->executeCommand($command);
    }
}
