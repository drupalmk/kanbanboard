<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:41
 */

namespace KanbanBoard\KanbanBoard\Entity\Github;

use KanbanBoard\KanbanBoard\Entity\EntityInterface;
use KanbanBoard\KanbanBoard\Entity\IssueInterface;
use KanbanBoard\KanbanBoard\Entity\MilestoneInterface;

class GithubMilestoneInterface implements EntityInterface, MilestoneInterface
{

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

    public function addIssue(IssueInterface $issue)
    {
        // TODO: Implement addIssue() method.
    }

    public function getIssue(): array
    {
        // TODO: Implement getIssue() method.
    }
}