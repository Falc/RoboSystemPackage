<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package\Test;

use Falc\Robo\Package\Uninstall;

/**
 * Uninstall tests.
 */
class UninstallTest extends BaseTestCase
{
    public function testWithoutPackageManager()
    {
        $task = $this->taskPackageUninstall();

        $this->setExpectedException('\Exception');
        $command = $task->getCommand();
    }

    public function testUnsupportedPackageManager()
    {
        $this->setExpectedException('\Exception');
        $task = $this->taskPackageUninstall('awesomepackagemanager');
    }

    public function testWithoutPackages()
    {
        $task = $this->taskPackageUninstall('yum');

        $this->setExpectedException('\Exception');
        $command = $task->getCommand();
    }

    public function testApt()
    {
        $task = $this->taskPackageUninstall()
            ->packageManager('apt')
            ->packages(['package1', 'package2']);

        $command = $task->getCommand();
        $expected = 'apt-get -y -qq remove package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testDnf()
    {
        $task = $this->taskPackageUninstall()
            ->packageManager('dnf')
            ->packages(['package1', 'package2']);

        $command = $task->getCommand();
        $expected = 'dnf -y -q remove package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testYum()
    {
        $task = $this->taskPackageUninstall()
            ->packageManager('yum')
            ->packages(['package1', 'package2']);

        $command = $task->getCommand();
        $expected = 'yum -y -q remove package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testVerbose()
    {
        $task = $this->taskPackageUninstall()
            ->packageManager('yum')
            ->packages(['package1', 'package2'])
            ->verbose();

        $command = $task->getCommand();
        $expected = 'yum -y remove package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testOneLiner()
    {
        $task1 = $this->taskPackageUninstall('yum', ['package1', 'package2']);

        $task2 = $this->taskPackageUninstall()
            ->packageManager('yum')
            ->packages(['package1', 'package2']);

        $this->assertEquals($task1->getCommand(), $task2->getCommand());
    }

    public function testRun()
    {
        $task = $this->createTaskMock('Falc\Robo\Package\Uninstall', ['executeCommand']);

        $task
            ->expects($this->once())
            ->method('executeCommand')
            ->will($this->returnValue(\Robo\Result::success($task, 'Success')));

        $task
            ->packageManager('yum')
            ->package('package1')
            ->run();
    }
}
