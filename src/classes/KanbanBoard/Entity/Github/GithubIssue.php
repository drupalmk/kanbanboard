<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:42
 */

namespace KanbanBoard\KanbanBoard\Entity\Github;

use KanbanBoard\KanbanBoard\Entity\IEntity;
use KanbanBoard\KanbanBoard\Entity\IIssue;

class GithubIssue implements IEntity, IIssue
{

    /**
     * @return string
     */
    public function getText()
    {
        // TODO: Implement getText() method.
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getText();
    }
}