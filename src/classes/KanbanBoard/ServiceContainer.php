<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 19/09/2018
 * Time: 13:01
 */

namespace KanbanBoard;

use KanbanBoard\Github\Config\Config;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * ProjectServiceContainer.
 *
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 */
class ServiceContainer extends Container
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(new ParameterBag($this->getDefaultParameters()));
        $this->methodMap = array(
          '_defaults' => 'getDefaultsService',
          'github_settings' => 'getGithubSettingsService',
        );
    }

    /**
     * Gets the 'github_settings' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \KanbanBoard\Github\Config\Config A KanbanBoard\Github\Config\Config instance.
     */
    protected function getGithubSettingsService()
    {
        return $this->services['github_settings'] = new Config($this->getParameter('config.directory'));
    }

    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return array(
          'config.directory' => __DIR__ . '/../../../',
        );
    }
}
