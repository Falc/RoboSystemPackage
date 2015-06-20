<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package;

use Robo\Common\ExecOneCommand;
use Robo\Contract\CommandInterface;
use Robo\Task\BaseTask as RoboBaseTask;

/**
 * Base class for all package tasks.
 */
abstract class BaseTask extends RoboBaseTask
{
    use ExecOneCommand;

    /**
     * Package manager to use.
     *
     * @var string
     */
    protected $packageManager;

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
     * Constructor.
     *
     * @param   string      $packageManager Package manager to use. Optional.
     * @param   string[]    $packages       Package list. Optional.
     */
    public function __construct($packageManager = null, array $packages = [])
    {
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
        $packageManager = strtolower($packageManager);

        if (!$this->isPackageManagerSupported($packageManager)) {
            throw new \Exception("{$packageManager} is not supported");
        }

        $this->packageManager = $packageManager;

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

    /**
     * Tells whether a package manager is supported or not.
     *
     * @param   string  $packageManager Package manager.
     * @return  boolean
     */
    protected function isPackageManagerSupported($packageManager)
    {
        return in_array($packageManager, ['apt', 'dnf', 'yum']);
    }
}
