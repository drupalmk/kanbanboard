<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 20/09/2018
 * Time: 11:51
 */

namespace KanbanBoard\Github\Test;

use Dotenv\Dotenv;
use KanbanBoard\Config\ConfigInterface;
use KanbanBoard\Github\Client\Github;
use KanbanBoard\Github\Config\Config;

class GithubClientTest extends \PHPUnit_Framework_TestCase
{

    const GH_TEST_REPOSITORY_KEY = 'GH_TEST_REPOSITORY_NAME';

    private $testRepositoryName;

    public function setUp()
    {
        $dotenv = new Dotenv(__DIR__, '/.env_test');
        $dotenv->load();
    }

    public function testCacheDirectoryCreation() {
        $configMock = $this->getConfigMock();
        new Github($configMock);
        $this->assertTrue(is_dir(getenv(Config::GH_CACHE_LOCATION)));
    }

    public function testFetchMilestones()
    {
        $client = new Github($this->getConfigMock());
        $milestones = $client->getMilestones();
        $this->testRepositoryName = getenv(self::GH_TEST_REPOSITORY_KEY);
        $this->assertArrayHasKey($repository, $milestones);
        $this->assertNotEmpty($milestones[$repository]);
        $this->assertNotEmpty($milestones[$repository][0]['title']);
    }

    /**
     * @expectedException Github\Exception\RuntimeException
     */
    public function testFetchMilestonesForNonExistingRepo()
    {
        $this->testRepositoryName = 'non-existing-repo';
        /** @var \PHPUnit_Framework_MockObject_MockObject $configMock */
        $configMock = $this->getConfigMock();
        $client = new Github($configMock);

        $milestones = $client->getMilestones();
    }

    /**
     * Get Config mock. By default its returns available values from .env_test file.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getConfigMock() {
        $configMock = $this->getMock(ConfigInterface::class);

        $configMock->method('getCacheLocation')
            ->willReturn(getenv(Config::GH_CACHE_LOCATION));

        $configMock->method('getRepositoryList')
            ->will(
              $this->returnCallback(function() {
                  return [$this->testRepositoryName];
              })
            );

        $configMock->method('getAccountName')
          ->willReturn(getenv(Config::GH_ACCOUNT_NAME));

        $configMock->method('getClientId')
            ->willReturn(getenv(Config::GH_CLIENT_ID));

        $configMock->method('getClientSecret')
            ->willReturn(getenv(Config::GH_CLIENT_SECRET));

        return $configMock;
    }
}