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
 * Update tests.
 */
class UpdateTest extends BaseTestCase
{
    public function testWithoutPackageManager()
    {
        $task = $this->taskPackageUpdate();

        $this->setExpectedException('\Exception');
        $command = $task->getCommand();
    }

    public function testUnsupportedPackageManager()
    {
        $this->setExpectedException('\Exception');
        $task = $this->taskPackageUpdate('awesomepackagemanager');
    }

    public function testApt()
    {
        $task = $this->taskPackageUpdate()
            ->packageManager('apt')
            ->packages(['package1', 'package2']);

        $command = $task->getCommand();
        $expected = 'apt-get -y -qq install --only-upgrade package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testAptUpdateAll()
    {
        $task = $this->taskPackageUpdate('apt');

        $command = $task->getCommand();
        $expected = 'apt-get -y -qq upgrade';
        $this->assertEquals($expected, $command);
    }

    public function testDnf()
    {
        $task = $this->taskPackageUpdate()
            ->packageManager('dnf')
            ->packages(['package1', 'package2']);

        $command = $task->getCommand();
        $expected = 'dnf -y -q update package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testDnfUpdateAll()
    {
        $task = $this->taskPackageUpdate('dnf');

        $command = $task->getCommand();
        $expected = 'dnf -y -q update';
        $this->assertEquals($expected, $command);
    }

    public function testYum()
    {
        $task = $this->taskPackageUpdate()
            ->packageManager('yum')
            ->packages(['package1', 'package2']);

        $command = $task->getCommand();
        $expected = 'yum -y -q update package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testYumUpdateAll()
    {
        $task = $this->taskPackageUpdate('yum');

        $command = $task->getCommand();
        $expected = 'yum -y -q update';
        $this->assertEquals($expected, $command);
    }

    public function testVerbose()
    {
        $task = $this->taskPackageUpdate()
            ->packageManager('yum')
            ->packages(['package1', 'package2'])
            ->verbose();

        $command = $task->getCommand();
        $expected = 'yum -y update package1 package2';
        $this->assertEquals($expected, $command);
    }

    public function testOneLiner()
    {
        $task1 = $this->taskPackageUpdate('yum', ['package1', 'package2']);

        $task2 = $this->taskPackageUpdate()
            ->packageManager('yum')
            ->packages(['package1', 'package2']);

        $this->assertEquals($task1->getCommand(), $task2->getCommand());
    }

    public function testRun()
    {
        $task = $this->createTaskMock('Falc\Robo\Package\Update', ['executeCommand']);

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
