<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package\Factory;

/**
 * CommandBuilderFactory interface.
 */
interface CommandBuilderFactoryInterface
{
    /**
     * Creates a CommandBuilder for the specified $packageManager.
     *
     * @param   string  $packageManager Package manager.
     * @return  \Falc\Robo\Package\CommandBuilder\CommandBuilderInterface
     */
    public function create($packageManager);
}
