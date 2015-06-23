<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package\Factory;

use Falc\Robo\Package\CommandBuilder;
use Falc\Robo\Package\Factory\CommandBuilderFactoryInterface;

/**
 * CommandBuilder factory.
 */
class CommandBuilderFactory implements CommandBuilderFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create($packageManager)
    {
        switch ($packageManager) {
            case 'apt':
                return new CommandBuilder\AptCommandBuilder();
            case 'dnf':
                return new CommandBuilder\DnfCommandBuilder();
            case 'pacman':
                return new CommandBuilder\PacmanCommandBuilder();
            case 'yum':
                return new CommandBuilder\YumCommandBuilder();
            default:
                throw new \Exception('Not supported');
        }
    }
}
