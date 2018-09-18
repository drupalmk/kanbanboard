<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:41
 */

namespace KanbanBoard\KanbanBoard\Entity\Github;

use KanbanBoard\KanbanBoard\Entity\IEntity;
use KanbanBoard\KanbanBoard\Entity\IIssue;
use KanbanBoard\KanbanBoard\Entity\IMilestone;

class GithubMilestone implements IEntity, IMilestone
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

    public function addIssue(IIssue $issue)
    {
        // TODO: Implement addIssue() method.
    }

    public function getIssue(): array
    {
        // TODO: Implement getIssue() method.
    }
}