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
 * Dnf command builder.
 */
class DnfCommandBuilder extends YumCommandBuilder
{
    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        $packages = implode(' ', array_unique($this->packages));
        $options = implode(' ', array_unique($this->options));

        $command = "dnf {$options} {$this->action} {$packages}";

        // Remove extra whitespaces
        $command = preg_replace('/\s+/', ' ', trim($command));

        return $command;
    }
}
