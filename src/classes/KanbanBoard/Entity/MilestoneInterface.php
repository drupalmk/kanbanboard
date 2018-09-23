<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:44
 */

namespace KanbanBoard\Entity;

interface MilestoneInterface extends EntityInterface
{

    /**
     * @param \KanbanBoard\Entity\IssueInterface $issue
     *
     * @return mixed
     */
    public function addIssue(IssueInterface $issue);

    /**
     * @return array
     */
    public function getIssues(): array;

    /**
     * @param int $progress
     *
     * @return void
     */
    public function setProgress(int $progress);

    /**
     * @return int
     */
    public function getProgress() : int;

}