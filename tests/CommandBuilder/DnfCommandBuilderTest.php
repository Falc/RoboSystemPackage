<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package\Test\CommandBuilder;

use Falc\Robo\Package\CommandBuilder\DnfCommandBuilder;
use Falc\Robo\Package\Test\BaseTestCase;

/**
 * DnfCommandBuilder tests.
 */
class DnfCommandBuilderTest extends BaseTestCase
{
    protected $dnf;

    protected function setUp()
    {
        $this->dnf = new DnfCommandBuilder();
    }

    public function testInstallWithoutPackages()
    {
        $this->setExpectedException('\Exception');
        $this->dnf->install([]);
    }

    public function testInstallSinglePackage()
    {
        $this->dnf->install(['package1']);

        $command = $this->dnf->getCommand();
        $expected = 'dnf install package1';
        $this->assertEquals($expected, $command);
    }

    public function testInstallManyPackages()
    {
        $this->dnf->install(['package1', 'package2']);

        $command = $this->dnf->getCommand();
        $expected = 'dnf install package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testUpdateAll()
    {
        $this->dnf->update();

        $command = $this->dnf->getCommand();
        $expected = 'dnf update';
        $this->assertEquals($expected, $command);
    }

    public function testUpdateSinglePackage()
    {
        $this->dnf->update(['package1']);

        $command = $this->dnf->getCommand();
        $expected = 'dnf update package1';
        $this->assertEquals($expected, $command);
    }

    public function testUpdateManyPackages()
    {
        $this->dnf->update(['package1', 'package2']);

        $command = $this->dnf->getCommand();
        $expected = 'dnf update package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testUninstallWithoutPackages()
    {
        $this->setExpectedException('\Exception');
        $this->dnf->uninstall([]);
    }

    public function testUninstallSinglePackage()
    {
        $this->dnf->uninstall(['package1']);

        $command = $this->dnf->getCommand();
        $expected = 'dnf remove package1';
        $this->assertEquals($expected, $command);
    }

    public function testUninstallManyPackages()
    {
        $this->dnf->uninstall(['package1', 'package2']);

        $command = $this->dnf->getCommand();
        $expected = 'dnf remove package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testAssumeYes()
    {
        $this->dnf->install(['package1'])->assumeYes();

        $command = $this->dnf->getCommand();
        $expected = 'dnf -y install package1';
        $this->assertEquals($expected, $command);
    }

    public function testQuiet()
    {
        $this->dnf->install(['package1'])->quiet();

        $command = $this->dnf->getCommand();
        $expected = 'dnf -q install package1';
        $this->assertEquals($expected, $command);
    }
}
