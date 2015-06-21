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
 * Package Uninstall
 *
 * ``` php
 * // Uninstalling a single package:
 * $this->taskPackageUninstall()
 *     ->packageManager('yum')
 *     ->package('package1')
 *     ->run();
 *
 * // Uninstalling many packages:
 * $this->taskPackageUninstall()
 *     ->packageManager('yum')
 *     ->packages(['package1', 'package2'])
 *     ->run();
 *
 * // Compact form:
 * $this->taskPackageUninstall('yum', ['package1', 'package2'])->run();
 *
 * // It is possible to specify a pattern:
 * $this->taskPackageUninstall()
 *     ->packageManager('yum')
 *     ->package('package1-*') // Uninstalls all packages starting with "package1-"
 *     ->run();
 * ```
 */
class Uninstall extends BaseTask implements CommandInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        if ($this->builder === null) {
            throw new \Exception('Package manager not defined');
        }

        $this->builder->uninstall($this->packages)->assumeYes();

        if (!$this->verbose) {
            $this->builder->quiet();
        }

        $this->command = $this->builder->getCommand();

        return $this->command;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $command = $this->getCommand();

        $this->printTaskInfo('Uninstalling packages...');
        return $this->executeCommand($command);
    }
}
