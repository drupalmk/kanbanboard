<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 20/09/2018
 * Time: 11:51
 */

namespace KanbanBoard\Github\Test;

use KanbanBoard\Github\Client\Github;

/**
 * Class GithubClientTest
 *
 * This class interacts with real Github API, so example repository with milestones and issues must be available.
 *
 * @package KanbanBoard\Github\Test
 */
class GithubClientTest extends BaseTest
{

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
}