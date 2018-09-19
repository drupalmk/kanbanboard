<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 19/09/2018
 * Time: 13:01
 */

namespace KanbanBoard\Github;

use KanbanBoard\Github\Config\Config;
use KanbanBoard\GithubClient;
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
          'github_settings' => 'getGithubSettingsService',
          'github_client' => 'getGithubClient',
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
     * @return \KanbanBoard\GithubClient
     */
    protected function getGithubClient() {
        return $this->services['github_client'] = new GithubClient($this->getGithubSettingsService());
    }

    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return array(
          'config.directory' => __DIR__ . '/../../../../',
        );
    }
}
