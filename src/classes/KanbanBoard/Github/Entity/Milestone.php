<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:41
 */

namespace KanbanBoard\KanbanBoard\Github\Entity;

use KanbanBoard\Entity\EntityInterface;
use KanbanBoard\Entity\IssueInterface;
use KanbanBoard\Entity\MilestoneInterface;

class Milestone implements EntityInterface, MilestoneInterface
{
    /**
     * @return int
     */
    public function getId(): int
    {
        // TODO: Implement getId() method.
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        // TODO: Implement getText() method.
    }

    /**
     * @inheritdoc
     */
    public function addIssue(IssueInterface $issue)
    {
        // TODO: Implement addIssue() method.
    }

    /**
     * @inheritdoc
     */
    public function getIssues(): array
    {
        // TODO: Implement getIssue() method.
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}