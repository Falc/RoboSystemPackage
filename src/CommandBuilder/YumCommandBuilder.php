<?php
/**
 * This file is part of RoboSystemPackage.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2015 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Robo\Package\CommandBuilder;

/**
 * Yum command builder.
 */
class YumCommandBuilder implements CommandBuilderInterface
{
    /**
     * Command action.
     *
     * @var string
     */
    protected $action;

    /**
     * Option list.
     *
     * @var string[]
     */
    protected $options = [];

    /**
     * Package list.
     *
     * @var string[]
     */
    protected $packages = [];

    /**
     * {@inheritdoc}
     */
    public function install(array $packages)
    {
        if (empty($packages)) {
            throw new \Exception('No packages selected to be installed');
        }

        $this->packages = $packages;
        $this->action = 'install';

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function update(array $packages = [])
    {
        $this->packages = $packages;
        $this->action = 'update';

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall(array $packages)
    {
        if (empty($packages)) {
            throw new \Exception('No packages selected to be uninstalled');
        }

        $this->packages = $packages;
        $this->action = 'remove';

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function assumeYes()
    {
        $this->options[] = '-y';

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function quiet()
    {
        $this->options[] = '-q';

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        $packages = implode(' ', array_unique($this->packages));
        $options = implode(' ', array_unique($this->options));

        $command = "yum {$options} {$this->action} {$packages}";

        // Remove extra whitespaces
        $command = preg_replace('/\s+/', ' ', trim($command));

        return $command;
    }
}
