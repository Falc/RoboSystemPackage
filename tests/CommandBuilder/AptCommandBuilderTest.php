<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package\Test\CommandBuilder;

use Falc\Robo\Package\CommandBuilder\AptCommandBuilder;
use Falc\Robo\Package\Test\BaseTestCase;

/**
 * AptCommandBuilder tests.
 */
class AptCommandBuilderTest extends BaseTestCase
{
    protected $apt;

    protected function setUp()
    {
        $this->apt = new AptCommandBuilder();
    }

    public function testInstallWithoutPackages()
    {
        $this->setExpectedException('\Exception');
        $this->apt->install([]);
    }

    public function testInstallSinglePackage()
    {
        $this->apt->install(['package1']);

        $command = $this->apt->getCommand();
        $expected = 'apt-get install package1';
        $this->assertEquals($expected, $command);
    }

    public function testInstallManyPackages()
    {
        $this->apt->install(['package1', 'package2']);

        $command = $this->apt->getCommand();
        $expected = 'apt-get install package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testUpdateAll()
    {
        $this->apt->update();

        $command = $this->apt->getCommand();
        $expected = 'apt-get upgrade';
        $this->assertEquals($expected, $command);
    }

    public function testUpdateSinglePackage()
    {
        $this->apt->update(['package1']);

        $command = $this->apt->getCommand();
        $expected = 'apt-get install --only-upgrade package1';
        $this->assertEquals($expected, $command);
    }

    public function testUpdateManyPackages()
    {
        $this->apt->update(['package1', 'package2']);

        $command = $this->apt->getCommand();
        $expected = 'apt-get install --only-upgrade package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testUninstallWithoutPackages()
    {
        $this->setExpectedException('\Exception');
        $this->apt->uninstall([]);
    }

    public function testUninstallSinglePackage()
    {
        $this->apt->uninstall(['package1']);

        $command = $this->apt->getCommand();
        $expected = 'apt-get remove package1';
        $this->assertEquals($expected, $command);
    }

    public function testUninstallManyPackages()
    {
        $this->apt->uninstall(['package1', 'package2']);

        $command = $this->apt->getCommand();
        $expected = 'apt-get remove package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testAssumeYes()
    {
        $this->apt->install(['package1'])->assumeYes();

        $command = $this->apt->getCommand();
        $expected = 'apt-get -y install package1';
        $this->assertEquals($expected, $command);
    }

    public function testQuiet()
    {
        $this->apt->install(['package1'])->quiet();

        $command = $this->apt->getCommand();
        $expected = 'apt-get -qq install package1';
        $this->assertEquals($expected, $command);
    }
}
