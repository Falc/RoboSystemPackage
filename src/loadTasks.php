<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package;

use Falc\Robo\Package\Factory\CommandBuilderFactoryInterface;

/**
 * Loads tasks.
 */
trait loadTasks
{
    /**
     * Allows to install packages.
     *
     * @param   string                          $packageManager Package manager to use. Optional.
     * @param   string[]                        $packages       Package list. Optional.
     * @param   CommandBuilderFactoryInterface  $factory        CommandBuilder factory. Optional.
     */
    protected function taskPackageInstall($packageManager = null, array $packages = [], CommandBuilderFactoryInterface $factory = null)
    {
        return new Install($packageManager, $packages, $factory);
    }

    /**
     * Allows to update packages.
     *
     * @param   string                          $packageManager Package manager to use. Optional.
     * @param   string[]                        $packages       Package list. Optional.
     * @param   CommandBuilderFactoryInterface  $factory        CommandBuilder factory. Optional.
     */
    protected function taskPackageUpdate($packageManager = null, array $packages = [], CommandBuilderFactoryInterface $factory = null)
    {
        return new Update($packageManager, $packages, $factory);
    }

    /**
     * Allows to uninstall packages.
     *
     * @param   string                          $packageManager Package manager to use. Optional.
     * @param   string[]                        $packages       Package list. Optional.
     * @param   CommandBuilderFactoryInterface  $factory        CommandBuilder factory. Optional.
     */
    protected function taskPackageUninstall($packageManager = null, array $packages = [], CommandBuilderFactoryInterface $factory = null)
    {
        return new Uninstall($packageManager, $packages, $factory);
    }
}
