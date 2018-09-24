<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 23/09/2018
 * Time: 20:20
 */

namespace KanbanBoard\Test;


use KanbanBoard\Entity\IssueState;
use KanbanBoard\Entity\MilestoneInterface;
use KanbanBoard\Github\Entity\Issue;
use KanbanBoard\Github\Entity\Milestone;
use KanbanBoard\View\Board;
use PHPUnit\Framework\TestCase;

class BoardViewTest extends TestCase
{
    public function testViewData() {

        $milestone = $this->createTestMilestone();
        $data = [$milestone];
        $view = new Board($data);
        $data = $view->getData();
        $processedMilestone = $data[0];
        $this->assertInstanceOf(MilestoneInterface::class, $processedMilestone);
        $this->assertCount(2, $processedMilestone->queued);
        $this->assertCount(5, $processedMilestone->active);
        $this->assertCount(2, $processedMilestone->completed);
    }

    private function createTestMilestone()
    {
        $milestone = new Milestone($this->randomId());
        $milestone->addIssue($this->createIssue(IssueState::queued()));
        $milestone->addIssue($this->createIssue(IssueState::active()));
        $milestone->addIssue($this->createIssue(IssueState::paused()));
        $milestone->addIssue($this->createIssue(IssueState::active()));
        $milestone->addIssue($this->createIssue(IssueState::completed()));
        $milestone->addIssue($this->createIssue(IssueState::paused()));
        $milestone->addIssue($this->createIssue(IssueState::active()));
        $milestone->addIssue($this->createIssue(IssueState::completed()));
        $milestone->addIssue($this->createIssue(IssueState::queued()));
        return $milestone;
    }

    private function createIssue(IssueState $state) {
        $generator = \Nubs\RandomNameGenerator\All::create();
        $issue = new Issue($this->randomId());
        $issue->setTitle($generator->getName());
        $issue->setState($state);
        return $issue;
    }

    private function randomId()
    {
        return rand(10, 10000);
    }
}