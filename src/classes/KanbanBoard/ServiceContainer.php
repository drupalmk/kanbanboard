<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 19/09/2018
 * Time: 13:01
 */

namespace KanbanBoard;

use KanbanBoard\Github\Board\BoardInteractor;
use KanbanBoard\Github\Client\Github;
use KanbanBoard\Github\Config\Config;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * ProjectServiceContainer.
 *
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 *
 * In reality this container should be created in extendable way.
 * Services related to Github should be created directly in Github module.
 * This is done for simplicity.
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
          'github_config' => 'getGithubConfig',
          'github_client' => 'getGithubClient',
          'github_board' => 'getGithubBoard',
          'authentication' => 'getAuthentication',
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
    protected function getGithubConfig()
    {
        return $this->services['github_config'] = new Config($this->getParameter('config.directory'));
    }

    /**
     * @return \KanbanBoard\Github\Client\Github
     */
    protected function getGithubClient() {
        $auth = $this->getAuthentication();
        return $this->services['github_client'] = new Github($this->getGithubConfig(), $auth->getToken());
    }

    /**
     * @return \KanbanBoard\Github\Board\BoardInteractor
     */
    protected function getGithubBoard() {
        return $this->services['github_board']
          = new BoardInteractor($this->getGithubClient(), $this->getGithubConfig());
    }

    protected function getAuthentication() {
        return $this->services['authentication']
          = new Authentication($this->getGithubConfig());
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
