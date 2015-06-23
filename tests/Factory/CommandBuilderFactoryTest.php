<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package\Test\Factory;

use Falc\Robo\Package\Factory\CommandBuilderFactory;
use Falc\Robo\Package\Test\BaseTestCase;

/**
 * CommandBuilderFactory tests.
 */
class CommandBuilderFactoryTest extends BaseTestCase
{
    protected $factory;

    protected function setUp()
    {
        $this->factory = new CommandBuilderFactory();
    }

    public function testCreateUnsupportedBuilder()
    {
        $this->setExpectedException('\Exception');
        $builder = $this->factory->create('mypackagemanager');
    }

    public function testCreateAptCommandBuilder()
    {
        $builder = $this->factory->create('apt');

        $this->assertInstanceOf('Falc\Robo\Package\CommandBuilder\CommandBuilderInterface', $builder);
    }

    public function testCreateDnfCommandBuilder()
    {
        $builder = $this->factory->create('dnf');

        $this->assertInstanceOf('Falc\Robo\Package\CommandBuilder\CommandBuilderInterface', $builder);
    }

    public function testCreatePacmanCommandBuilder()
    {
        $builder = $this->factory->create('pacman');

        $this->assertInstanceOf('Falc\Robo\Package\CommandBuilder\CommandBuilderInterface', $builder);
    }

    public function testCreateYumCommandBuilder()
    {
        $builder = $this->factory->create('yum');

        $this->assertInstanceOf('Falc\Robo\Package\CommandBuilder\CommandBuilderInterface', $builder);
    }
}
