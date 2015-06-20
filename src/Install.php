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
        if ($this->packageManager === null) {
            throw new \Exception('Package manager not defined');
        }

        if (empty($this->packages)) {
            throw new \Exception('No packages selected to be installed');
        }

        switch ($this->packageManager) {
            case 'apt':
                $command = 'apt-get';
                $action = 'install';
                $assumeYes = '-y';
                $quiet = '-qq';
                break;
            case 'dnf':
                $command = 'dnf';
                $action = 'install';
                $assumeYes = '-y';
                $quiet = '-q';
                break;
            case 'yum':
                $command = 'yum';
                $action = 'install';
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

        $this->printTaskInfo('Installing packages...');
        return $this->executeCommand($command);
    }
}
