<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 21/09/2018
 * Time: 11:46
 */

namespace KanbanBoard\KanbanBoard\Github\Test;

use KanbanBoard\Client\ClientInterface;
use KanbanBoard\Entity\IssueInterface;
use KanbanBoard\Entity\IssueState;
use KanbanBoard\Entity\MilestoneInterface;
use KanbanBoard\Github\Board\BoardInteractor;
use KanbanBoard\Github\Test\BaseTest;

/**
 * This tests aren't require access to Github API. Sample data is provided.
 *
 * @package KanbanBoard\KanbanBoard\Github\Test
 */
class GithubBoardInteractorTest extends BaseTest
{

    public function testFetchMilestones()
    {
        $client = $this->getMockBuilder(ClientInterface::class)
          ->disableOriginalConstructor()
          ->getMock();

        $client->method('getMilestones')
          ->willReturn($this->getClientMilestonesData());

        $client->method('getIssues')
          ->willReturn($this->getClientIssuesData());

        $interactor = new BoardInteractor($client, $this->getConfigMock());
        $milestones = $interactor->getMilestones();

        $this->assertTrue(is_array($milestones));
        $this->assertNotEmpty($milestones);
        $this->assertCount(1, $milestones);
        $this->assertContainsOnlyInstancesOf(
          MilestoneInterface::class,
          $milestones
        );
        $index = key($milestones);
        /** @var MilestoneInterface $milestone */
        $milestone = $milestones[$index];
        $this->assertEquals('Sample milestone #1', $milestone->getTitle());
        $this->assertEquals('Sample milestone #1', $milestone);
        $this->assertNotEmpty($milestone->getId());
        $this->assertTrue(is_numeric($milestone->getId()));
        $this->assertSame(25, $milestone->getProgress());
        $url = 'https://github.com/drupalmk/sample-repository/milestone/1';
        $this->assertSame($url, $milestone->getUrl());

        $issues = $milestone->getIssues();
        $this->assertTrue(is_array($issues));
        $this->assertNotEmpty($issues);
        $this->assertContainsOnlyInstancesOf(IssueInterface::class, $issues);

        $issues = $milestone->issues;
        $this->assertTrue(is_array($issues));
        $this->assertContainsOnlyInstancesOf(IssueInterface::class, $issues);

        $index = key($issues);
        /** @var IssueInterface $issue */
        $issue = $issues[$index];
        $this->assertTrue(is_numeric($issue->getId()));
        $this->assertNotEmpty($issue->getTitle());
        $this->assertTrue(is_string($issue->getTitle()));
        $this->assertSame($issue->getState(), IssueState::queued());
        $url = 'https://github.com/drupalmk/sample-repository/issues/4';
        $this->assertSame($url, $issue->getUrl());
        $this->assertEmpty($issue->getAvatarUrl());

        /** @var IssueInterface $pausedIssue */
        $pausedIssue = $issues[2];
        $this->assertNotNull($pausedIssue);
        $this->assertSame($pausedIssue->getState(), IssueState::paused());
        $this->assertNotEmpty($pausedIssue->getAvatarUrl());
        $avatarUrl = 'https://avatars1.githubusercontent.com/u/596909?v=4';
        $this->assertSame($pausedIssue->getAvatarUrl(), $avatarUrl);

    }

    private function getClientMilestonesData()
    {
        return [
          'sample-repository' =>
            [
              0 =>
                [
                  'url' => 'https://api.github.com/repos/drupalmk/sample-repository/milestones/1',
                  'html_url' => 'https://github.com/drupalmk/sample-repository/milestone/1',
                  'labels_url' => 'https://api.github.com/repos/drupalmk/sample-repository/milestones/1/labels',
                  'id' => 3655943,
                  'node_id' => 'MDk6TWlsZXN0b25lMzY1NTk0Mw==',
                  'number' => 1,
                  'title' => 'Sample milestone #1',
                  'description' => '',
                  'creator' =>
                    [
                      'login' => 'drupalmk',
                      'id' => 596909,
                      'node_id' => 'MDQ6VXNlcjU5NjkwOQ==',
                      'avatar_url' => 'https://avatars1.githubusercontent.com/u/596909?v=4',
                      'gravatar_id' => '',
                      'url' => 'https://api.github.com/users/drupalmk',
                      'html_url' => 'https://github.com/drupalmk',
                      'followers_url' => 'https://api.github.com/users/drupalmk/followers',
                      'following_url' => 'https://api.github.com/users/drupalmk/following{/other_user}',
                      'gists_url' => 'https://api.github.com/users/drupalmk/gists{/gist_id}',
                      'starred_url' => 'https://api.github.com/users/drupalmk/starred{/owner}{/repo}',
                      'subscriptions_url' => 'https://api.github.com/users/drupalmk/subscriptions',
                      'organizations_url' => 'https://api.github.com/users/drupalmk/orgs',
                      'repos_url' => 'https://api.github.com/users/drupalmk/repos',
                      'events_url' => 'https://api.github.com/users/drupalmk/events{/privacy}',
                      'received_events_url' => 'https://api.github.com/users/drupalmk/received_events',
                      'type' => 'User',
                      'site_admin' => false,
                    ],
                  'open_issues' => 3,
                  'closed_issues' => 1,
                  'state' => 'open',
                  'created_at' => '2018-09-14T22:02:39Z',
                  'updated_at' => '2018-09-17T13:45:33Z',
                  'due_on' => '2018-09-24T07:00:00Z',
                  'closed_at' => null,
                ],
            ],
        ];
    }

    private function getClientIssuesData()
    {
        return array (
          3655943 =>
            array (
              0 =>
                array (
                  'url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/4',
                  'repository_url' => 'https://api.github.com/repos/drupalmk/sample-repository',
                  'labels_url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/4/labels{/name}',
                  'comments_url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/4/comments',
                  'events_url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/4/events',
                  'html_url' => 'https://github.com/drupalmk/sample-repository/issues/4',
                  'id' => 360876758,
                  'node_id' => 'MDU6SXNzdWUzNjA4NzY3NTg=',
                  'number' => 4,
                  'title' => 'Another issue',
                  'user' =>
                    array (
                      'login' => 'drupalmk',
                      'id' => 596909,
                      'node_id' => 'MDQ6VXNlcjU5NjkwOQ==',
                      'avatar_url' => 'https://avatars1.githubusercontent.com/u/596909?v=4',
                      'gravatar_id' => '',
                      'url' => 'https://api.github.com/users/drupalmk',
                      'html_url' => 'https://github.com/drupalmk',
                      'followers_url' => 'https://api.github.com/users/drupalmk/followers',
                      'following_url' => 'https://api.github.com/users/drupalmk/following{/other_user}',
                      'gists_url' => 'https://api.github.com/users/drupalmk/gists{/gist_id}',
                      'starred_url' => 'https://api.github.com/users/drupalmk/starred{/owner}{/repo}',
                      'subscriptions_url' => 'https://api.github.com/users/drupalmk/subscriptions',
                      'organizations_url' => 'https://api.github.com/users/drupalmk/orgs',
                      'repos_url' => 'https://api.github.com/users/drupalmk/repos',
                      'events_url' => 'https://api.github.com/users/drupalmk/events{/privacy}',
                      'received_events_url' => 'https://api.github.com/users/drupalmk/received_events',
                      'type' => 'User',
                      'site_admin' => false,
                    ),
                  'labels' =>
                    array (
                    ),
                  'state' => 'open',
                  'locked' => false,
                  'assignee' => NULL,
                  'assignees' =>
                    array (
                    ),
                  'milestone' =>
                    array (
                      'url' => 'https://api.github.com/repos/drupalmk/sample-repository/milestones/1',
                      'html_url' => 'https://github.com/drupalmk/sample-repository/milestone/1',
                      'labels_url' => 'https://api.github.com/repos/drupalmk/sample-repository/milestones/1/labels',
                      'id' => 3655943,
                      'node_id' => 'MDk6TWlsZXN0b25lMzY1NTk0Mw==',
                      'number' => 1,
                      'title' => 'Sample milestone #1',
                      'description' => '',
                      'creator' =>
                        array (
                          'login' => 'drupalmk',
                          'id' => 596909,
                          'node_id' => 'MDQ6VXNlcjU5NjkwOQ==',
                          'avatar_url' => 'https://avatars1.githubusercontent.com/u/596909?v=4',
                          'gravatar_id' => '',
                          'url' => 'https://api.github.com/users/drupalmk',
                          'html_url' => 'https://github.com/drupalmk',
                          'followers_url' => 'https://api.github.com/users/drupalmk/followers',
                          'following_url' => 'https://api.github.com/users/drupalmk/following{/other_user}',
                          'gists_url' => 'https://api.github.com/users/drupalmk/gists{/gist_id}',
                          'starred_url' => 'https://api.github.com/users/drupalmk/starred{/owner}{/repo}',
                          'subscriptions_url' => 'https://api.github.com/users/drupalmk/subscriptions',
                          'organizations_url' => 'https://api.github.com/users/drupalmk/orgs',
                          'repos_url' => 'https://api.github.com/users/drupalmk/repos',
                          'events_url' => 'https://api.github.com/users/drupalmk/events{/privacy}',
                          'received_events_url' => 'https://api.github.com/users/drupalmk/received_events',
                          'type' => 'User',
                          'site_admin' => false,
                        ),
                      'open_issues' => 3,
                      'closed_issues' => 1,
                      'state' => 'open',
                      'created_at' => '2018-09-14T22:02:39Z',
                      'updated_at' => '2018-09-17T13:45:33Z',
                      'due_on' => '2018-09-24T07:00:00Z',
                      'closed_at' => NULL,
                    ),
                  'comments' => 0,
                  'created_at' => '2018-09-17T13:45:33Z',
                  'updated_at' => '2018-09-17T13:45:33Z',
                  'closed_at' => NULL,
                  'author_association' => 'OWNER',
                  'body' => '',
                ),
              1 =>
                array (
                  'url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/3',
                  'repository_url' => 'https://api.github.com/repos/drupalmk/sample-repository',
                  'labels_url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/3/labels{/name}',
                  'comments_url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/3/comments',
                  'events_url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/3/events',
                  'html_url' => 'https://github.com/drupalmk/sample-repository/issues/3',
                  'id' => 360548376,
                  'node_id' => 'MDU6SXNzdWUzNjA1NDgzNzY=',
                  'number' => 3,
                  'title' => 'Sample issue #3',
                  'user' =>
                    array (
                      'login' => 'drupalmk',
                      'id' => 596909,
                      'node_id' => 'MDQ6VXNlcjU5NjkwOQ==',
                      'avatar_url' => 'https://avatars1.githubusercontent.com/u/596909?v=4',
                      'gravatar_id' => '',
                      'url' => 'https://api.github.com/users/drupalmk',
                      'html_url' => 'https://github.com/drupalmk',
                      'followers_url' => 'https://api.github.com/users/drupalmk/followers',
                      'following_url' => 'https://api.github.com/users/drupalmk/following{/other_user}',
                      'gists_url' => 'https://api.github.com/users/drupalmk/gists{/gist_id}',
                      'starred_url' => 'https://api.github.com/users/drupalmk/starred{/owner}{/repo}',
                      'subscriptions_url' => 'https://api.github.com/users/drupalmk/subscriptions',
                      'organizations_url' => 'https://api.github.com/users/drupalmk/orgs',
                      'repos_url' => 'https://api.github.com/users/drupalmk/repos',
                      'events_url' => 'https://api.github.com/users/drupalmk/events{/privacy}',
                      'received_events_url' => 'https://api.github.com/users/drupalmk/received_events',
                      'type' => 'User',
                      'site_admin' => false,
                    ),
                  'labels' =>
                    array (
                    ),
                  'state' => 'closed',
                  'locked' => false,
                  'assignee' =>
                    array (
                      'login' => 'drupalmk',
                      'id' => 596909,
                      'node_id' => 'MDQ6VXNlcjU5NjkwOQ==',
                      'avatar_url' => 'https://avatars1.githubusercontent.com/u/596909?v=4',
                      'gravatar_id' => '',
                      'url' => 'https://api.github.com/users/drupalmk',
                      'html_url' => 'https://github.com/drupalmk',
                      'followers_url' => 'https://api.github.com/users/drupalmk/followers',
                      'following_url' => 'https://api.github.com/users/drupalmk/following{/other_user}',
                      'gists_url' => 'https://api.github.com/users/drupalmk/gists{/gist_id}',
                      'starred_url' => 'https://api.github.com/users/drupalmk/starred{/owner}{/repo}',
                      'subscriptions_url' => 'https://api.github.com/users/drupalmk/subscriptions',
                      'organizations_url' => 'https://api.github.com/users/drupalmk/orgs',
                      'repos_url' => 'https://api.github.com/users/drupalmk/repos',
                      'events_url' => 'https://api.github.com/users/drupalmk/events{/privacy}',
                      'received_events_url' => 'https://api.github.com/users/drupalmk/received_events',
                      'type' => 'User',
                      'site_admin' => false,
                    ),
                  'assignees' =>
                    array (
                      0 =>
                        array (
                          'login' => 'drupalmk',
                          'id' => 596909,
                          'node_id' => 'MDQ6VXNlcjU5NjkwOQ==',
                          'avatar_url' => 'https://avatars1.githubusercontent.com/u/596909?v=4',
                          'gravatar_id' => '',
                          'url' => 'https://api.github.com/users/drupalmk',
                          'html_url' => 'https://github.com/drupalmk',
                          'followers_url' => 'https://api.github.com/users/drupalmk/followers',
                          'following_url' => 'https://api.github.com/users/drupalmk/following{/other_user}',
                          'gists_url' => 'https://api.github.com/users/drupalmk/gists{/gist_id}',
                          'starred_url' => 'https://api.github.com/users/drupalmk/starred{/owner}{/repo}',
                          'subscriptions_url' => 'https://api.github.com/users/drupalmk/subscriptions',
                          'organizations_url' => 'https://api.github.com/users/drupalmk/orgs',
                          'repos_url' => 'https://api.github.com/users/drupalmk/repos',
                          'events_url' => 'https://api.github.com/users/drupalmk/events{/privacy}',
                          'received_events_url' => 'https://api.github.com/users/drupalmk/received_events',
                          'type' => 'User',
                          'site_admin' => false,
                        ),
                    ),
                  'milestone' =>
                    array (
                      'url' => 'https://api.github.com/repos/drupalmk/sample-repository/milestones/1',
                      'html_url' => 'https://github.com/drupalmk/sample-repository/milestone/1',
                      'labels_url' => 'https://api.github.com/repos/drupalmk/sample-repository/milestones/1/labels',
                      'id' => 3655943,
                      'node_id' => 'MDk6TWlsZXN0b25lMzY1NTk0Mw==',
                      'number' => 1,
                      'title' => 'Sample milestone #1',
                      'description' => '',
                      'creator' =>
                        array (
                          'login' => 'drupalmk',
                          'id' => 596909,
                          'node_id' => 'MDQ6VXNlcjU5NjkwOQ==',
                          'avatar_url' => 'https://avatars1.githubusercontent.com/u/596909?v=4',
                          'gravatar_id' => '',
                          'url' => 'https://api.github.com/users/drupalmk',
                          'html_url' => 'https://github.com/drupalmk',
                          'followers_url' => 'https://api.github.com/users/drupalmk/followers',
                          'following_url' => 'https://api.github.com/users/drupalmk/following{/other_user}',
                          'gists_url' => 'https://api.github.com/users/drupalmk/gists{/gist_id}',
                          'starred_url' => 'https://api.github.com/users/drupalmk/starred{/owner}{/repo}',
                          'subscriptions_url' => 'https://api.github.com/users/drupalmk/subscriptions',
                          'organizations_url' => 'https://api.github.com/users/drupalmk/orgs',
                          'repos_url' => 'https://api.github.com/users/drupalmk/repos',
                          'events_url' => 'https://api.github.com/users/drupalmk/events{/privacy}',
                          'received_events_url' => 'https://api.github.com/users/drupalmk/received_events',
                          'type' => 'User',
                          'site_admin' => false,
                        ),
                      'open_issues' => 3,
                      'closed_issues' => 1,
                      'state' => 'open',
                      'created_at' => '2018-09-14T22:02:39Z',
                      'updated_at' => '2018-09-17T13:45:33Z',
                      'due_on' => '2018-09-24T07:00:00Z',
                      'closed_at' => NULL,
                    ),
                  'comments' => 0,
                  'created_at' => '2018-09-15T15:12:57Z',
                  'updated_at' => '2018-09-15T15:13:02Z',
                  'closed_at' => '2018-09-15T15:13:02Z',
                  'author_association' => 'OWNER',
                  'body' => 'Sample issue which is closed',
                ),
              2 =>
                array (
                  'url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/2',
                  'repository_url' => 'https://api.github.com/repos/drupalmk/sample-repository',
                  'labels_url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/2/labels{/name}',
                  'comments_url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/2/comments',
                  'events_url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/2/events',
                  'html_url' => 'https://github.com/drupalmk/sample-repository/issues/2',
                  'id' => 360468556,
                  'node_id' => 'MDU6SXNzdWUzNjA0Njg1NTY=',
                  'number' => 2,
                  'title' => 'Sample issue #2',
                  'user' =>
                    array (
                      'login' => 'drupalmk',
                      'id' => 596909,
                      'node_id' => 'MDQ6VXNlcjU5NjkwOQ==',
                      'avatar_url' => 'https://avatars1.githubusercontent.com/u/596909?v=4',
                      'gravatar_id' => '',
                      'url' => 'https://api.github.com/users/drupalmk',
                      'html_url' => 'https://github.com/drupalmk',
                      'followers_url' => 'https://api.github.com/users/drupalmk/followers',
                      'following_url' => 'https://api.github.com/users/drupalmk/following{/other_user}',
                      'gists_url' => 'https://api.github.com/users/drupalmk/gists{/gist_id}',
                      'starred_url' => 'https://api.github.com/users/drupalmk/starred{/owner}{/repo}',
                      'subscriptions_url' => 'https://api.github.com/users/drupalmk/subscriptions',
                      'organizations_url' => 'https://api.github.com/users/drupalmk/orgs',
                      'repos_url' => 'https://api.github.com/users/drupalmk/repos',
                      'events_url' => 'https://api.github.com/users/drupalmk/events{/privacy}',
                      'received_events_url' => 'https://api.github.com/users/drupalmk/received_events',
                      'type' => 'User',
                      'site_admin' => false,
                    ),
                  'labels' =>
                    array (
                      0 =>
                        array (
                          'id' => 1066434954,
                          'node_id' => 'MDU6TGFiZWwxMDY2NDM0OTU0',
                          'url' => 'https://api.github.com/repos/drupalmk/sample-repository/labels/foo',
                          'name' => 'foo',
                          'color' => '9aebf9',
                          'default' => false,
                        ),
                      1 =>
                        array (
                          'id' => 1066434881,
                          'node_id' => 'MDU6TGFiZWwxMDY2NDM0ODgx',
                          'url' => 'https://api.github.com/repos/drupalmk/sample-repository/labels/waiting-for-feedback',
                          'name' => 'waiting-for-feedback',
                          'color' => 'c419a2',
                          'default' => false,
                        ),
                    ),
                  'state' => 'open',
                  'locked' => false,
                  'assignee' =>
                    array (
                      'login' => 'drupalmk',
                      'id' => 596909,
                      'node_id' => 'MDQ6VXNlcjU5NjkwOQ==',
                      'avatar_url' => 'https://avatars1.githubusercontent.com/u/596909?v=4',
                      'gravatar_id' => '',
                      'url' => 'https://api.github.com/users/drupalmk',
                      'html_url' => 'https://github.com/drupalmk',
                      'followers_url' => 'https://api.github.com/users/drupalmk/followers',
                      'following_url' => 'https://api.github.com/users/drupalmk/following{/other_user}',
                      'gists_url' => 'https://api.github.com/users/drupalmk/gists{/gist_id}',
                      'starred_url' => 'https://api.github.com/users/drupalmk/starred{/owner}{/repo}',
                      'subscriptions_url' => 'https://api.github.com/users/drupalmk/subscriptions',
                      'organizations_url' => 'https://api.github.com/users/drupalmk/orgs',
                      'repos_url' => 'https://api.github.com/users/drupalmk/repos',
                      'events_url' => 'https://api.github.com/users/drupalmk/events{/privacy}',
                      'received_events_url' => 'https://api.github.com/users/drupalmk/received_events',
                      'type' => 'User',
                      'site_admin' => false,
                    ),
                  'assignees' =>
                    array (
                      0 =>
                        array (
                          'login' => 'drupalmk',
                          'id' => 596909,
                          'node_id' => 'MDQ6VXNlcjU5NjkwOQ==',
                          'avatar_url' => 'https://avatars1.githubusercontent.com/u/596909?v=4',
                          'gravatar_id' => '',
                          'url' => 'https://api.github.com/users/drupalmk',
                          'html_url' => 'https://github.com/drupalmk',
                          'followers_url' => 'https://api.github.com/users/drupalmk/followers',
                          'following_url' => 'https://api.github.com/users/drupalmk/following{/other_user}',
                          'gists_url' => 'https://api.github.com/users/drupalmk/gists{/gist_id}',
                          'starred_url' => 'https://api.github.com/users/drupalmk/starred{/owner}{/repo}',
                          'subscriptions_url' => 'https://api.github.com/users/drupalmk/subscriptions',
                          'organizations_url' => 'https://api.github.com/users/drupalmk/orgs',
                          'repos_url' => 'https://api.github.com/users/drupalmk/repos',
                          'events_url' => 'https://api.github.com/users/drupalmk/events{/privacy}',
                          'received_events_url' => 'https://api.github.com/users/drupalmk/received_events',
                          'type' => 'User',
                          'site_admin' => false,
                        ),
                    ),
                  'milestone' =>
                    array (
                      'url' => 'https://api.github.com/repos/drupalmk/sample-repository/milestones/1',
                      'html_url' => 'https://github.com/drupalmk/sample-repository/milestone/1',
                      'labels_url' => 'https://api.github.com/repos/drupalmk/sample-repository/milestones/1/labels',
                      'id' => 3655943,
                      'node_id' => 'MDk6TWlsZXN0b25lMzY1NTk0Mw==',
                      'number' => 1,
                      'title' => 'Sample milestone #1',
                      'description' => '',
                      'creator' =>
                        array (
                          'login' => 'drupalmk',
                          'id' => 596909,
                          'node_id' => 'MDQ6VXNlcjU5NjkwOQ==',
                          'avatar_url' => 'https://avatars1.githubusercontent.com/u/596909?v=4',
                          'gravatar_id' => '',
                          'url' => 'https://api.github.com/users/drupalmk',
                          'html_url' => 'https://github.com/drupalmk',
                          'followers_url' => 'https://api.github.com/users/drupalmk/followers',
                          'following_url' => 'https://api.github.com/users/drupalmk/following{/other_user}',
                          'gists_url' => 'https://api.github.com/users/drupalmk/gists{/gist_id}',
                          'starred_url' => 'https://api.github.com/users/drupalmk/starred{/owner}{/repo}',
                          'subscriptions_url' => 'https://api.github.com/users/drupalmk/subscriptions',
                          'organizations_url' => 'https://api.github.com/users/drupalmk/orgs',
                          'repos_url' => 'https://api.github.com/users/drupalmk/repos',
                          'events_url' => 'https://api.github.com/users/drupalmk/events{/privacy}',
                          'received_events_url' => 'https://api.github.com/users/drupalmk/received_events',
                          'type' => 'User',
                          'site_admin' => false,
                        ),
                      'open_issues' => 3,
                      'closed_issues' => 1,
                      'state' => 'open',
                      'created_at' => '2018-09-14T22:02:39Z',
                      'updated_at' => '2018-09-17T13:45:33Z',
                      'due_on' => '2018-09-24T07:00:00Z',
                      'closed_at' => NULL,
                    ),
                  'comments' => 0,
                  'created_at' => '2018-09-14T22:03:52Z',
                  'updated_at' => '2018-09-23T11:00:03Z',
                  'closed_at' => NULL,
                  'author_association' => 'OWNER',
                  'body' => 'Sample issue #2 with user assigned',
                ),
              3 =>
                array (
                  'url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/1',
                  'repository_url' => 'https://api.github.com/repos/drupalmk/sample-repository',
                  'labels_url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/1/labels{/name}',
                  'comments_url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/1/comments',
                  'events_url' => 'https://api.github.com/repos/drupalmk/sample-repository/issues/1/events',
                  'html_url' => 'https://github.com/drupalmk/sample-repository/issues/1',
                  'id' => 360468426,
                  'node_id' => 'MDU6SXNzdWUzNjA0Njg0MjY=',
                  'number' => 1,
                  'title' => 'Sample issue #1',
                  'user' =>
                    array (
                      'login' => 'drupalmk',
                      'id' => 596909,
                      'node_id' => 'MDQ6VXNlcjU5NjkwOQ==',
                      'avatar_url' => 'https://avatars1.githubusercontent.com/u/596909?v=4',
                      'gravatar_id' => '',
                      'url' => 'https://api.github.com/users/drupalmk',
                      'html_url' => 'https://github.com/drupalmk',
                      'followers_url' => 'https://api.github.com/users/drupalmk/followers',
                      'following_url' => 'https://api.github.com/users/drupalmk/following{/other_user}',
                      'gists_url' => 'https://api.github.com/users/drupalmk/gists{/gist_id}',
                      'starred_url' => 'https://api.github.com/users/drupalmk/starred{/owner}{/repo}',
                      'subscriptions_url' => 'https://api.github.com/users/drupalmk/subscriptions',
                      'organizations_url' => 'https://api.github.com/users/drupalmk/orgs',
                      'repos_url' => 'https://api.github.com/users/drupalmk/repos',
                      'events_url' => 'https://api.github.com/users/drupalmk/events{/privacy}',
                      'received_events_url' => 'https://api.github.com/users/drupalmk/received_events',
                      'type' => 'User',
                      'site_admin' => false,
                    ),
                  'labels' =>
                    array (
                    ),
                  'state' => 'open',
                  'locked' => false,
                  'assignee' => NULL,
                  'assignees' =>
                    array (
                    ),
                  'milestone' =>
                    array (
                      'url' => 'https://api.github.com/repos/drupalmk/sample-repository/milestones/1',
                      'html_url' => 'https://github.com/drupalmk/sample-repository/milestone/1',
                      'labels_url' => 'https://api.github.com/repos/drupalmk/sample-repository/milestones/1/labels',
                      'id' => 3655943,
                      'node_id' => 'MDk6TWlsZXN0b25lMzY1NTk0Mw==',
                      'number' => 1,
                      'title' => 'Sample milestone #1',
                      'description' => '',
                      'creator' =>
                        array (
                          'login' => 'drupalmk',
                          'id' => 596909,
                          'node_id' => 'MDQ6VXNlcjU5NjkwOQ==',
                          'avatar_url' => 'https://avatars1.githubusercontent.com/u/596909?v=4',
                          'gravatar_id' => '',
                          'url' => 'https://api.github.com/users/drupalmk',
                          'html_url' => 'https://github.com/drupalmk',
                          'followers_url' => 'https://api.github.com/users/drupalmk/followers',
                          'following_url' => 'https://api.github.com/users/drupalmk/following{/other_user}',
                          'gists_url' => 'https://api.github.com/users/drupalmk/gists{/gist_id}',
                          'starred_url' => 'https://api.github.com/users/drupalmk/starred{/owner}{/repo}',
                          'subscriptions_url' => 'https://api.github.com/users/drupalmk/subscriptions',
                          'organizations_url' => 'https://api.github.com/users/drupalmk/orgs',
                          'repos_url' => 'https://api.github.com/users/drupalmk/repos',
                          'events_url' => 'https://api.github.com/users/drupalmk/events{/privacy}',
                          'received_events_url' => 'https://api.github.com/users/drupalmk/received_events',
                          'type' => 'User',
                          'site_admin' => false,
                        ),
                      'open_issues' => 3,
                      'closed_issues' => 1,
                      'state' => 'open',
                      'created_at' => '2018-09-14T22:02:39Z',
                      'updated_at' => '2018-09-17T13:45:33Z',
                      'due_on' => '2018-09-24T07:00:00Z',
                      'closed_at' => NULL,
                    ),
                  'comments' => 0,
                  'created_at' => '2018-09-14T22:03:13Z',
                  'updated_at' => '2018-09-14T22:03:13Z',
                  'closed_at' => NULL,
                  'author_association' => 'OWNER',
                  'body' => 'Sample issue #1 in milestone #1',
                ),
            ),
        );
    }


}