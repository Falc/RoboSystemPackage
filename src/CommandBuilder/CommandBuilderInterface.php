<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package\CommandBuilder;

/**
 * CommandBuilder interface.
 */
interface CommandBuilderInterface
{
    /**
     * Sets the action to "install" and specifies the packages.
     *
     * @param   string[]            $packages List of packages to install.
     * @return  CommandBuilderInterface
     */
    public function install(array $packages);

    /**
     * Sets the action to "update" and specifies the packages, if any.
     *
     * @param   string[]            $packages List of packages to update. Optional. No packages means "update everything".
     * @return  CommandBuilderInterface
     */
    public function update(array $packages = []);

    /**
     * Sets the action to "uninstall" and specifies the packages.
     *
     * @param   string[]            $packages List of packages to uninstall.
     * @return  CommandBuilderInterface
     */
    public function uninstall(array $packages);

    /**
     * Sets the option "assume yes".
     *
     * The package manager will not ask for confirmation.
     *
     * @return CommandBuilderInterface
     */
    public function assumeYes();

    /**
     * Sets the option "quiet".
     *
     * The package manager will not display output.
     *
     * @return CommandBuilderInterface
     */
    public function quiet();

    /**
     * Gets the resulting command.
     *
     * @return string
     */
    public function getCommand();
}
