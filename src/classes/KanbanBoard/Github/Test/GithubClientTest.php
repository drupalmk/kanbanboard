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
use PHPUnit\Framework\TestCase;

/**
 * Class GithubClientTest
 *
 * This class interacts with real Github API, so example repository with milestones and issues must be available.
 *
 * @package KanbanBoard\Github\Test
 */
class GithubClientTest extends TestCase
{
    private $testRepositoryName;

    public function setUp()
    {
        $dotenv = new Dotenv(__DIR__, '/.env_test');
        $dotenv->load();
        $this->testRepositoryName = getenv(self::GH_TEST_REPOSITORY_KEY);
    }

    public function testCacheDirectoryCreation() {
        $configMock = $this->getConfigMock();
        new Github($configMock);
        $this->assertTrue(is_dir(getenv(self::GH_TEST_CACHE_LOCATION)));
    }

    public function testFetchMilestones()
    {
        $client = new Github($this->getConfigMock());
        $milestones = $client->getMilestones();
        $this->assertArrayHasKey($this->testRepositoryName, $milestones);
        $this->assertNotEmpty($milestones[$this->testRepositoryName]);
        $this->assertNotEmpty($milestones[$this->testRepositoryName][0]['title']);
    }

    /**
     * @TODO in reality external exception should be wrapped or handle directly in the client.
     * @expectedException \Github\Exception\RuntimeException
     */
    public function testFetchMilestonesForNonExistingRepo()
    {
        $this->testRepositoryName = 'non-existing-repo';
        /** @var \PHPUnit_Framework_MockObject_MockObject $configMock */
        $configMock = $this->getConfigMock();
        $client = new Github($configMock);
        $client->getMilestones();
    }

    public function testFetchIssues()
    {
        $config = $this->getConfigMock();
        $client = new Github($config);
        $issues = $client->getIssues();
        $this->assertNotEmpty($issues);
        $milestoneId = key($issues);
        $milestoneIssues = $issues[$milestoneId];
        $this->assertNotEmpty($milestoneIssues);
        $this->assertNotEmpty($milestoneIssues[0]['title']);
    }

    /**
     * Get Config mock. By default its returns available values from .env_test file.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getConfigMock() {
        $configMock = $this->createMock(ConfigInterface::class);
        $configMock->method('getCacheLocation')
            ->willReturn(getenv(self::GH_TEST_CACHE_LOCATION));

        $configMock->method('getRepositoryList')
            ->will(
              $this->returnCallback(function() {
                  return [$this->testRepositoryName];
              })
            );

        $configMock->method('getAccountName')
          ->willReturn(getenv(self::GH_TEST_ACCOUNT));

        $configMock->method('getClientId')
            ->willReturn(getenv(self::GH_TEST_CLIENT_ID));

        $configMock->method('getClientSecret')
            ->willReturn(getenv(self::GH_TEST_CLIENT_SECRET));

        return $configMock;
    }

    const GH_TEST_REPOSITORY_KEY = 'GH_TEST_REPOSITORY_NAME';

    const GH_TEST_CACHE_LOCATION = 'GH_TEST_CACHE_LOCATION';

    const GH_TEST_ACCOUNT = 'GH_TEST_ACCOUNT';

    const GH_TEST_CLIENT_ID = 'GH_TEST_CLIENT_ID';

    const GH_TEST_CLIENT_SECRET = 'GH_TEST_CLIENT_SECRET';
}