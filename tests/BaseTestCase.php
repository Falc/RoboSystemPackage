<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package\Test;

use Falc\Robo\Package;

/**
 * BaseTestCase.
 */
class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    use Package\loadTasks;

    protected function createCommandBuilderMock()
    {
        $mock = $this->getMockBuilder('Falc\Robo\Package\CommandBuilder\CommandBuilderInterface')
            ->setMethods(['install', 'update', 'uninstall', 'assumeYes', 'quiet', 'getCommand'])
            ->getMock();

        $mock
            ->method('install')
            ->will($this->returnValue($mock));

        $mock
            ->method('update')
            ->will($this->returnValue($mock));

        $mock
            ->method('uninstall')
            ->will($this->returnValue($mock));

        $mock
            ->method('assumeYes')
            ->will($this->returnValue($mock));

        $mock
            ->method('quiet')
            ->will($this->returnValue($mock));

        return $mock;
    }

    protected function createFactoryMock($builder)
    {
        $mock = $this->getMockBuilder('Falc\Robo\Package\Factory\CommandBuilderFactory')
            ->setMethods(['create'])
            ->getMock();

        $mock
            ->method('create')
            ->will($this->returnValue($builder));

        return $mock;
    }
}
