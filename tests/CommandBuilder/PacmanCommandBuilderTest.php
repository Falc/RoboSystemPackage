<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package\Test\CommandBuilder;

use Falc\Robo\Package\CommandBuilder\PacmanCommandBuilder;
use Falc\Robo\Package\Test\BaseTestCase;

/**
 * PacmanCommandBuilder tests.
 */
class PacmanCommandBuilderTest extends BaseTestCase
{
    protected $pacman;

    protected function setUp()
    {
        $this->pacman = new PacmanCommandBuilder();
    }

    public function testInstallWithoutPackages()
    {
        $this->setExpectedException('\Exception');
        $this->pacman->install([]);
    }

    public function testInstallSinglePackage()
    {
        $this->pacman->install(['package1']);

        $command = $this->pacman->getCommand();
        $expected = 'pacman -Sy package1';
        $this->assertEquals($expected, $command);
    }

    public function testInstallManyPackages()
    {
        $this->pacman->install(['package1', 'package2']);

        $command = $this->pacman->getCommand();
        $expected = 'pacman -Sy package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testUpdateAll()
    {
        $this->pacman->update();

        $command = $this->pacman->getCommand();
        $expected = 'pacman -Syu';
        $this->assertEquals($expected, $command);
    }

    public function testUpdateSinglePackage()
    {
        $this->pacman->update(['package1']);

        $command = $this->pacman->getCommand();
        $expected = 'pacman -Sy package1';
        $this->assertEquals($expected, $command);
    }

    public function testUpdateManyPackages()
    {
        $this->pacman->update(['package1', 'package2']);

        $command = $this->pacman->getCommand();
        $expected = 'pacman -Sy package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testUninstallWithoutPackages()
    {
        $this->setExpectedException('\Exception');
        $this->pacman->uninstall([]);
    }

    public function testUninstallSinglePackage()
    {
        $this->pacman->uninstall(['package1']);

        $command = $this->pacman->getCommand();
        $expected = 'pacman -Rs package1';
        $this->assertEquals($expected, $command);
    }

    public function testUninstallManyPackages()
    {
        $this->pacman->uninstall(['package1', 'package2']);

        $command = $this->pacman->getCommand();
        $expected = 'pacman -Rs package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testAssumeYes()
    {
        $this->pacman->install(['package1'])->assumeYes();

        $command = $this->pacman->getCommand();
        $expected = 'pacman -Sy --noconfirm package1';
        $this->assertEquals($expected, $command);
    }

    public function testQuiet()
    {
        $this->pacman->install(['package1'])->quiet();

        $command = $this->pacman->getCommand();
        $expected = 'pacman -Sy package1 1> /dev/null';
        $this->assertEquals($expected, $command);
    }
}
