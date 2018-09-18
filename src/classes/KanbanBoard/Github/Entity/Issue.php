<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:42
 */

namespace KanbanBoard\Github\Entity;

use KanbanBoard\Entity\EntityInterface;
use KanbanBoard\Entity\IssueInterface;

class Issue implements EntityInterface, IssueInterface
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