<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:42
 */

namespace KanbanBoard\Github\Entity;

use KanbanBoard\Entity\IssueInterface;

class Issue implements IssueInterface
{
    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        // TODO: Implement setTitle() method.
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        // TODO: Implement getText() method.
    }

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
    public function __toString()
    {
        return $this->getTitle();
    }
}