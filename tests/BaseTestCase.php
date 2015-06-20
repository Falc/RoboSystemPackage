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

    protected function createTaskMock($class, array $stubMethods = [])
    {
        $mock = $this->getMockBuilder($class)
            ->setMethods($stubMethods)
            ->getMock();

        return $mock;
    }
}
