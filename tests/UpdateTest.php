<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package\Test;

use Falc\Robo\Package\Test\BaseTestCase;
use Falc\Robo\Package\Update;
use Robo\Result;

/**
 * Update tests.
 */
class UpdateTest extends BaseTestCase
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

        $task = $this->taskPackageUpdate(null, [], $this->factory)
            ->getCommand();
    }

    public function testWithoutPackages()
    {
        // It must call update() without packages
        $this->builder
            ->expects($this->once())
            ->method('update')
            ->with($this->equalTo([]));

        // It must call assumeYes() since it is a default option
        $this->builder
            ->expects($this->once())
            ->method('assumeYes');

        $this->taskPackageUpdate(null, [], $this->factory)
            ->packageManager('mypackagemanager')
            ->getCommand();
    }

    public function testWithSinglePackage()
    {
        $package = 'package1';

        // It must call update() with only one package
        $this->builder
            ->expects($this->once())
            ->method('update')
            ->with($this->equalTo([$package]));

        // It must call assumeYes() since it is a default option
        $this->builder
            ->expects($this->once())
            ->method('assumeYes');

        $this->taskPackageUpdate(null, [], $this->factory)
            ->packageManager('mypackagemanager')
            ->package($package)
            ->getCommand();
    }

    public function testWithManyPackages()
    {
        $packages = ['package1', 'package2'];

        // It must call update() with the specified packages
        $this->builder
            ->expects($this->once())
            ->method('update')
            ->with($this->equalTo($packages));

        // It must call assumeYes() since it is a default option
        $this->builder
            ->expects($this->once())
            ->method('assumeYes');

        $this->taskPackageUpdate(null, [], $this->factory)
            ->packageManager('mypackagemanager')
            ->packages($packages)
            ->getCommand();
    }

    public function testQuiet()
    {
        // It must call update()
        $this->builder
            ->expects($this->once())
            ->method('update');

        // It must call assumeYes() since it is a default option
        $this->builder
            ->expects($this->once())
            ->method('assumeYes');

        // It must call quiet()
        $this->builder
            ->expects($this->once())
            ->method('quiet');

        $this->taskPackageUpdate(null, [], $this->factory)
            ->packageManager('mypackagemanager')
            ->getCommand();
    }

    public function testVerbose()
    {
        // It must call update()
        $this->builder
            ->expects($this->once())
            ->method('update');

        // It must call assumeYes() since it is a default option
        $this->builder
            ->expects($this->once())
            ->method('assumeYes');

        // It must NOT call quiet()
        $this->builder
            ->expects($this->never())
            ->method('quiet');

        $this->taskPackageUpdate(null, [], $this->factory)
            ->packageManager('mypackagemanager')
            ->verbose()
            ->getCommand();
    }

    public function testOneLiner()
    {
        $packages = ['package1', 'package2'];

        // It must call update() with the specified packages
        $this->builder
            ->expects($this->once())
            ->method('update')
            ->with($this->equalTo($packages));

        // It must call assumeYes() since it is a default option
        $this->builder
            ->expects($this->once())
            ->method('assumeYes');

        $this->taskPackageUpdate('mypackagemanager', $packages, $this->factory)->getCommand();
    }

    public function testRun()
    {
        // Task mock
        $task = $this->getMockBuilder('Falc\Robo\Package\Update')
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
