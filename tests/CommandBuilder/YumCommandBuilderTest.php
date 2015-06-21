<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package\Test\CommandBuilder;

use Falc\Robo\Package\CommandBuilder\YumCommandBuilder;
use Falc\Robo\Package\Test\BaseTestCase;

/**
 * YumCommandBuilder tests.
 */
class YumCommandBuilderTest extends BaseTestCase
{
    protected $yum;

    protected function setUp()
    {
        $this->yum = new YumCommandBuilder();
    }

    public function testInstallWithoutPackages()
    {
        $this->setExpectedException('\Exception');
        $this->yum->install([]);
    }

    public function testInstallSinglePackage()
    {
        $this->yum->install(['package1']);

        $command = $this->yum->getCommand();
        $expected = 'yum install package1';
        $this->assertEquals($expected, $command);
    }

    public function testInstallManyPackages()
    {
        $this->yum->install(['package1', 'package2']);

        $command = $this->yum->getCommand();
        $expected = 'yum install package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testUpdateAll()
    {
        $this->yum->update();

        $command = $this->yum->getCommand();
        $expected = 'yum update';
        $this->assertEquals($expected, $command);
    }

    public function testUpdateSinglePackage()
    {
        $this->yum->update(['package1']);

        $command = $this->yum->getCommand();
        $expected = 'yum update package1';
        $this->assertEquals($expected, $command);
    }

    public function testUpdateManyPackages()
    {
        $this->yum->update(['package1', 'package2']);

        $command = $this->yum->getCommand();
        $expected = 'yum update package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testUninstallWithoutPackages()
    {
        $this->setExpectedException('\Exception');
        $this->yum->uninstall([]);
    }

    public function testUninstallSinglePackage()
    {
        $this->yum->uninstall(['package1']);

        $command = $this->yum->getCommand();
        $expected = 'yum remove package1';
        $this->assertEquals($expected, $command);
    }

    public function testUninstallManyPackages()
    {
        $this->yum->uninstall(['package1', 'package2']);

        $command = $this->yum->getCommand();
        $expected = 'yum remove package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testAssumeYes()
    {
        $this->yum->install(['package1'])->assumeYes();

        $command = $this->yum->getCommand();
        $expected = 'yum -y install package1';
        $this->assertEquals($expected, $command);
    }

    public function testQuiet()
    {
        $this->yum->install(['package1'])->quiet();

        $command = $this->yum->getCommand();
        $expected = 'yum -q install package1';
        $this->assertEquals($expected, $command);
    }
}
