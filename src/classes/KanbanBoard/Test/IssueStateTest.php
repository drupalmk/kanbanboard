<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 21/09/2018
 * Time: 15:00
 */

namespace KanbanBoard\Test;


use KanbanBoard\Entity\IssueState;
use PHPUnit\Framework\TestCase;

class IssueStateTest extends TestCase
{
    public function testIssueState() {
        $state = new IssueState(IssueState::Queued);
        $this->assertEquals('queued', $state);

        $state = new IssueState('queued');
        $this->assertEquals('queued', $state);

        $state = new IssueState(IssueState::Active);
        $this->assertEquals('active', $state);

        $state = new IssueState('active');
        $this->assertEquals('active', $state);

        $state = new IssueState(IssueState::Completed);
        $this->assertEquals('completed', $state);

        $state = new IssueState('completed');
        $this->assertEquals('completed', $state);
    }

    public function testInvalidState() {
        $this->expectExceptionMessage('Invalid state value: 5. Allowed values: 1, 2, 3');
        $state = new IssueState(5);

        $this->expectExceptionMessage('Invalid state label: invalid. Allowed values: queued, active, completed');
        $state = new IssueState('invalid');
    }
}