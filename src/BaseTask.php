<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package;

use Falc\Robo\Package\Factory\CommandBuilderFactory;
use Falc\Robo\Package\Factory\CommandBuilderFactoryInterface;
use Robo\Common\ExecOneCommand;
use Robo\Task\BaseTask as RoboBaseTask;

/**
 * Base class for all package tasks.
 */
abstract class BaseTask extends RoboBaseTask
{
    use ExecOneCommand;

    /**
     * Package list.
     *
     * @var string[]
     */
    protected $packages;

    /**
     * Option list.
     *
     * @var string[]
     */
    protected $options;

    /**
     * Whether verbose mode is enabled or not.
     *
     * @var boolean
     */
    protected $verbose = false;

    /**
     * CommandBuilder factory.
     *
     * @var CommandBuilderFactoryInterface
     */
    protected $factory;

    /**
     * CommandBuilder.
     *
     * @var \Falc\Robo\Package\CommandBuilder\CommandBuilderInterface
     */
    protected $builder;

    /**
     * Constructor.
     *
     * @param   string                          $packageManager Package manager to use. Optional.
     * @param   string[]                        $packages       Package list. Optional.
     * @param   CommandBuilderFactoryInterface  $factory        CommandBuilder factory. Optional.
     */
    public function __construct($packageManager = null, array $packages = [], CommandBuilderFactoryInterface $factory = null)
    {
        $this->factory = $factory ?: new CommandBuilderFactory();

        if ($packageManager) {
            $this->packageManager($packageManager);
        }

        $this->options = [];

        $this->packages = [];

        if (!empty($packages)) {
            $this->packages($packages);
        }
    }

    /**
     * Sets the package manager to use.
     *
     * @param   string  $packageManager Package manager to use.
     * @return  BaseTask
     */
    public function packageManager($packageManager)
    {
        $this->builder = $this->factory->create(strtolower($packageManager));

        return $this;
    }

    /**
     * Adds a package to the package list.
     *
     * @param   string  $package    Package.
     * @return  BaseTask
     */
    public function package($package)
    {
        $this->packages[] = trim($package);

        return $this;
    }

    /**
     * Adds packages to the package list.
     *
     * @param   string[]    $packages   List of packages.
     * @return  BaseTask
     */
    public function packages(array $packages)
    {
        foreach ($packages as $package) {
            $this->package($package);
        }

        return $this;
    }

    /**
     * Enables the verbose mode.
     *
     * @return BaseTask
     */
    public function verbose()
    {
        $this->verbose = true;

        return $this;
    }
}
