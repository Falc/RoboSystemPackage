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
use Falc\Robo\Package\Test\BaseTestCase;
use Robo\Result;

/**
 * Install tests.
 */
class InstallTest extends BaseTestCase
{
    protected $builder;
    protected $factory;

    protected function setUp()
    {
        $this->builder = $this->createCommandBuilderMock();
        $this->factory = $this->createFactoryMock($this->builder);
    }

    public function testWithoutPackageManager()
    {
        $this->setExpectedException('\Exception');

        $task = $this->taskPackageInstall(null, [], $this->factory)
            ->getCommand();
    }

    public function testWithoutPackages()
    {
        // It must call install() without packages
        $this->builder
            ->expects($this->once())
            ->method('install')
            ->with($this->equalTo([]));

        // It must call assumeYes() since it is a default option
        $this->builder
            ->expects($this->once())
            ->method('assumeYes');

        $this->taskPackageInstall(null, [], $this->factory)
            ->packageManager('mypackagemanager')
            ->getCommand();
    }

    public function testWithSinglePackage()
    {
        $package = 'package1';

        // It must call install() with only one package
        $this->builder
            ->expects($this->once())
            ->method('install')
            ->with($this->equalTo([$package]));

        // It must call assumeYes() since it is a default option
        $this->builder
            ->expects($this->once())
            ->method('assumeYes');

        $this->taskPackageInstall(null, [], $this->factory)
            ->packageManager('mypackagemanager')
            ->package($package)
            ->getCommand();
    }

    public function testWithManyPackages()
    {
        $packages = ['package1', 'package2'];

        // It must call install() with the specified packages
        $this->builder
            ->expects($this->once())
            ->method('install')
            ->with($this->equalTo($packages));

        // It must call assumeYes() since it is a default option
        $this->builder
            ->expects($this->once())
            ->method('assumeYes');

        $this->taskPackageInstall(null, [], $this->factory)
            ->packageManager('mypackagemanager')
            ->packages($packages)
            ->getCommand();
    }

    public function testQuiet()
    {
        // It must call install()
        $this->builder
            ->expects($this->once())
            ->method('install');

        // It must call assumeYes() since it is a default option
        $this->builder
            ->expects($this->once())
            ->method('assumeYes');

        // It must call quiet()
        $this->builder
            ->expects($this->once())
            ->method('quiet');

        $this->taskPackageInstall(null, [], $this->factory)
            ->packageManager('mypackagemanager')
            ->getCommand();
    }

    public function testVerbose()
    {
        // It must call install()
        $this->builder
            ->expects($this->once())
            ->method('install');

        // It must call assumeYes() since it is a default option
        $this->builder
            ->expects($this->once())
            ->method('assumeYes');

        // It must NOT call quiet()
        $this->builder
            ->expects($this->never())
            ->method('quiet');

        $this->taskPackageInstall(null, [], $this->factory)
            ->packageManager('mypackagemanager')
            ->verbose()
            ->getCommand();
    }

    public function testOneLiner()
    {
        $packages = ['package1', 'package2'];

        // It must call install() with the specified packages
        $this->builder
            ->expects($this->once())
            ->method('install')
            ->with($this->equalTo($packages));

        // It must call assumeYes() since it is a default option
        $this->builder
            ->expects($this->once())
            ->method('assumeYes');

        $this->taskPackageInstall('mypackagemanager', $packages, $this->factory)->getCommand();
    }

    public function testRun()
    {
        // Task mock
        $task = $this->getMockBuilder('Falc\Robo\Package\Install')
            ->setConstructorArgs([null, [], $this->factory])
            ->setMethods(['executeCommand'])
            ->getMock();

        // It must call executeCommand()
        $task
            ->expects($this->once())
            ->method('executeCommand')
            ->will($this->returnValue(Result::success($task, 'Success')));

        $task
            ->packageManager('mypackagemanager')
            ->package('package1')
            ->run();
    }
}
