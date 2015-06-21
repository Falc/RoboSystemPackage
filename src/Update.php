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
 * Package Update
 *
 * ``` php
 * // Updating a single package:
 * $this->taskPackageUpdate()
 *     ->packageManager('yum')
 *     ->package('package1')
 *     ->run();
 *
 * // Updating many packages:
 * $this->taskPackageUpdate()
 *     ->packageManager('yum')
 *     ->packages(['package1', 'package2'])
 *     ->run();
 *
 * // Compact form:
 * $this->taskPackageUpdate('yum', ['package1', 'package2'])->run();
 *
 * // It allows to specify packages conditionally:
 * $update = $this->taskPackageUpdate('yum', ['package1']);
 *
 * if ($requiresPackage2) {
 *     $update->package('package2');
 * }
 *
 * $update->run();
 *
 * // It is possible to specify a pattern:
 * $this->taskPackageUpdate()
 *     ->packageManager('yum')
 *     ->package('package1-*') // Updates all packages starting with "package1-"
 *     ->run();
 * ```
 */
class Update extends BaseTask implements CommandInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        if ($this->builder === null) {
            throw new \Exception('Package manager not defined');
        }

        $this->builder->update($this->packages)->assumeYes();

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

        $this->printTaskInfo('Updating packages...');
        return $this->executeCommand($command);
    }
}
