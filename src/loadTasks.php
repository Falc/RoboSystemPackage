<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package;

/**
 * Loads tasks.
 */
trait loadTasks
{
    /**
     * Allows to install packages.
     *
     * @param   string      $packageManager Package manager to use. Optional.
     * @param   string[]    $packages       Package list. Optional.
     */
    protected function taskPackageInstall($packageManager = null, array $packages = [])
    {
        return new Install($packageManager, $packages);
    }

    /**
     * Allows to update packages.
     *
     * @param   string      $packageManager Package manager to use. Optional.
     * @param   string[]    $packages       Package list. Optional.
     */
    protected function taskPackageUpdate($packageManager = null, array $packages = [])
    {
        return new Update($packageManager, $packages);
    }

    /**
     * Allows to uninstall packages.
     *
     * @param   string      $packageManager Package manager to use. Optional.
     * @param   string[]    $packages       Package list. Optional.
     */
    protected function taskPackageUninstall($packageManager = null, array $packages = [])
    {
        return new Uninstall($packageManager, $packages);
    }
}
