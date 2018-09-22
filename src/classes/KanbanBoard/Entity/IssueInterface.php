<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:46
 */

namespace KanbanBoard\Entity;

interface IssueInterface extends EntityInterface
{

    /**
     * @param \KanbanBoard\Entity\IssueState $state
     *
     * @return void
     */
    public function setState(IssueState $state);

    /**
     * @return \KanbanBoard\Entity\IssueState
     */
    public function getState() : IssueState;

}