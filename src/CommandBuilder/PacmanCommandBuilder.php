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
 * Pacman command builder.
 */
class PacmanCommandBuilder implements CommandBuilderInterface
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
     * Whether quiet mode is enabled or not.
     *
     * @var boolean
     */
    protected $quiet = false;

    /**
     * {@inheritdoc}
     */
    public function install(array $packages)
    {
        if (empty($packages)) {
            throw new \Exception('No packages selected to be installed');
        }

        $this->packages = $packages;
        $this->action = 'Sy';

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function update(array $packages = [])
    {
        $this->packages = $packages;
        $this->action = empty($packages) ? 'Syu' : 'Sy';

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
        $this->action = 'Rs';

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function assumeYes()
    {
        $this->options[] = '--noconfirm';

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function quiet()
    {
        $this->quiet = true;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        $packages = implode(' ', array_unique($this->packages));
        $options = implode(' ', array_unique($this->options));

        $command = "pacman -{$this->action} {$options} {$packages}";

        if ($this->quiet === true) {
            $command .= ' 1> /dev/null';
        }

        // Remove extra whitespaces
        $command = preg_replace('/\s+/', ' ', trim($command));

        return $command;
    }
}
