<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:41
 */

namespace KanbanBoard\KanbanBoard\Github\Entity;

use KanbanBoard\KanbanBoard\Entity\EntityInterface;
use KanbanBoard\KanbanBoard\Entity\IssueInterface;
use KanbanBoard\KanbanBoard\Entity\MilestoneInterface;

class GithubMilestone implements EntityInterface, MilestoneInterface
{

    public function addIssue(IssueInterface $issue)
    {
        // TODO: Implement addIssue() method.
    }

    public function getIssue(): array
    {
        // TODO: Implement getIssue() method.
    }

    /**
     * @return string
     */
    public function getText()
    {
        // TODO: Implement getText() method.
    }

    public function __toString()
    {
        return $this->getText();
    }

}