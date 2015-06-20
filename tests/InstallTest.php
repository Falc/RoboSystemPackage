<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package\Test;

use Falc\Robo\Package\Install;

/**
 * Install tests.
 */
class InstallTest extends BaseTestCase
{
    public function testWithoutPackageManager()
    {
        $task = $this->taskPackageInstall();

        $this->setExpectedException('\Exception');
        $command = $task->getCommand();
    }

    public function testUnsupportedPackageManager()
    {
        $this->setExpectedException('\Exception');
        $task = $this->taskPackageInstall('awesomepackagemanager');
    }

    public function testWithoutPackages()
    {
        $task = $this->taskPackageInstall('yum');

        $this->setExpectedException('\Exception');
        $command = $task->getCommand();
    }

    public function testApt()
    {
        $task = $this->taskPackageInstall()
            ->packageManager('apt')
            ->packages(['package1', 'package2']);

        $command = $task->getCommand();
        $expected = 'apt-get -y -qq install package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testDnf()
    {
        $task = $this->taskPackageInstall()
            ->packageManager('dnf')
            ->packages(['package1', 'package2']);

        $command = $task->getCommand();
        $expected = 'dnf -y -q install package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testYum()
    {
        $task = $this->taskPackageInstall()
            ->packageManager('yum')
            ->packages(['package1', 'package2']);

        $command = $task->getCommand();
        $expected = 'yum -y -q install package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testVerbose()
    {
        $task = $this->taskPackageInstall()
            ->packageManager('yum')
            ->packages(['package1', 'package2'])
            ->verbose();

        $command = $task->getCommand();
        $expected = 'yum -y install package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testOneLiner()
    {
        $task1 = $this->taskPackageInstall('yum', ['package1', 'package2']);

        $task2 = $this->taskPackageInstall()
            ->packageManager('yum')
            ->packages(['package1', 'package2']);

        $this->assertEquals($task1->getCommand(), $task2->getCommand());
    }

    public function testRun()
    {
        $task = $this->createTaskMock('Falc\Robo\Package\Install', ['executeCommand']);

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
