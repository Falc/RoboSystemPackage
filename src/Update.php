<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package;

use Robo\Common\ExecOneCommand;
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
        if ($this->packageManager === null) {
            throw new \Exception('Package manager not defined');
        }

        switch ($this->packageManager) {
            case 'apt':
                $command = 'apt-get';
                $action = empty($this->packages) ? 'upgrade' : 'install --only-upgrade';
                $assumeYes = '-y';
                $quiet = '-qq';
                break;
            case 'dnf':
                $command = 'dnf';
                $action = 'update';
                $assumeYes = '-y';
                $quiet = '-q';
                break;
            case 'yum':
                $command = 'yum';
                $action = 'update';
                $assumeYes = '-y';
                $quiet = '-q';
                break;
        }

        $this->options[] = $assumeYes;

        if (!$this->verbose) {
            $this->options[] = $quiet;
        }

        $options = implode(' ', $this->options);

        $this->command = "{$command} {$options} {$action}";

        if (empty($this->packages)) {
            return $this->command;
        }

        $packages = implode(' ', array_unique($this->packages));
        return "{$this->command} {$packages}";
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
