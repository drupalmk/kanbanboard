<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 20/09/2018
 * Time: 09:59
 */

namespace KanbanBoard\Github\Client;

use Cache\Adapter\Filesystem\FilesystemCachePool;
use Github\Client;
use KanbanBoard\Client\ClientInterface;
use KanbanBoard\Config\ConfigInterface;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

class Github implements ClientInterface
{

    /**
     * @var \KanbanBoard\Config\ConfigInterface
     */
    private $config;

    /**
     * @var \Github\Client
     */
    private $githubClient;

    /**
     * Milestones per repository.
     *
     * @var array
     */
    private $milestones;

    /**
     * Issues per milestone id.
     *
     * @var array
     */
    private $issues;

    /**
     * Initialize Github API.
     *
     * @param \KanbanBoard\Config\ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        //@TODO Consider Client also injectable.
        $this->githubClient = new Client();

        $this->githubClient->authenticate(
            $config->getClientId(),
            $config->getClientSecret(),
            Client::AUTH_URL_CLIENT_ID
        );

        //@TODO Consider directory path configurable also.
        $filesystemAdapter = new Local($config->getCacheLocation());
        $filesystem = new Filesystem($filesystemAdapter);
        // Adding cache layer can be also done in wrapper class (decorator).
        $pool = new FilesystemCachePool($filesystem);
        $this->githubClient->addCache($pool);
    }

    /**
     * @return array
     *    Milestones for every available repository, keyed by repository name.
     * @throws \Exception
     *    When repository names in config file are not available.
     */
    public function getMilestones(): array
    {
        if (isset($this->milestones)) {
            return $this->milestones;
        }

        $repositories = $this->config->getRepositoryList();

        if (empty($repositories)) {
            throw new \Exception("There aren't any repository configured from to fetch issues");
        }

        foreach ($repositories as $repository) {
            $milestones = $this->githubClient->api('issues')
              ->milestones($this->config->getAccountName(), $repository);

            $this->milestones[$repository] = is_array($milestones) ? $milestones: [];
        }

        return $this->milestones;
    }

    /**
     * @return array
     *    Array of issues keyed by milestone ID.
     * @throws \Exception
     */
    public function getIssues(): array
    {
        if (isset($this->issues)) {
            return $this->issues;
        }

        $milestones = $this->getMilestones();
        $this->issues = [];

        foreach ($milestones as $repository => $milestone) {
            $id = $milestone['number'];
            $params = ['milestone' => $id, 'state' => 'all'];
            $issues = $this->githubClient->api('issues')
              ->all($this->config->getAccountName(), $repository, $params);
            $this->issues[$id] = is_array($issues) ? $issues : [];
        }

        return $this->issues;
    }
}