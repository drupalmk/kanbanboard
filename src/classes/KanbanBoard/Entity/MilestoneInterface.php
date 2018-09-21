<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:44
 */

namespace KanbanBoard\Entity;


interface MilestoneInterface
{

    public function addIssue(IssueInterface $issue);

    public function getIssue(): array;

}