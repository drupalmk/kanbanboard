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
    public function testIssueState()
    {
        $state = IssueState::queued();
        $this->assertEquals('queued', $state);

        $state = IssueState::active();
        $this->assertEquals('active', $state);

        $state = IssueState::completed();
        $this->assertEquals('completed', $state);
    }

}