<?php

namespace KanbanBoard;

use Cache\Adapter\Filesystem\FilesystemCachePool;
use Github\Client;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

class GithubClient
{

    private $client;

    private $milestone_api;

    private $account;

    public function __construct($token, $account)
    {
        require '../../vendor/autoload.php';
        $this->account = $account;
        $this->client = new Client();

        $filesystemAdapter = new Local(__DIR__ . '/../../../.cache');
        $filesystem        = new Filesystem($filesystemAdapter);

        $pool = new FilesystemCachePool($filesystem);
        $this->client->addCache($pool);

        $this->client->authenticate($token, Client::AUTH_HTTP_TOKEN);
        $this->milestone_api = $this->client->api('issues')->milestones();
    }

    public function milestones($repository)
    {
        return $this->milestone_api->all($this->account, $repository);
    }

    public function issues($repository, $milestone_id)
    {
        $issue_parameters = ['milestone' => $milestone_id, 'state' => 'all'];

        return $this->client->api('issue')->all(
          $this->account,
          $repository,
          $issue_parameters
        );
    }
}