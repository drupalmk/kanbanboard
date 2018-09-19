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

    public function __construct(Config\ConfigInterface $config)
    {
        $this->account = $config->getAccountName();
        $this->client = new Client();

        try {
            $this->client->authenticate(
                $config->getClientId(),
                $config->getClientSecret(),
                Client::AUTH_URL_CLIENT_ID
            );
        } catch (\Exception $ex) {
            //@TODO just dummy exception handling here.
            print "Github authentication failed\n";
            print $ex->getMessage();
            die();
        }

        $filesystemAdapter = new Local(__DIR__ . '/../../../.cache');
        $filesystem = new Filesystem($filesystemAdapter);

        $pool = new FilesystemCachePool($filesystem);
        $this->client->addCache($pool);
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