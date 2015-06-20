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
        if ($this->packageManager === null) {
            throw new \Exception('Package manager not defined');
        }

        if (empty($this->packages)) {
            throw new \Exception('No packages selected to be uninstalled');
        }

        switch ($this->packageManager) {
            case 'apt':
                $command = 'apt-get';
                $action = 'remove';
                $assumeYes = '-y';
                $quiet = '-qq';
                break;
            case 'dnf':
                $command = 'dnf';
                $action = 'remove';
                $assumeYes = '-y';
                $quiet = '-q';
                break;
            case 'yum':
                $command = 'yum';
                $action = 'remove';
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

        $packages = implode(' ', array_unique($this->packages));
        return "{$this->command} {$packages}";
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
