<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:44
 */

namespace KanbanBoard\KanbanBoard\Entity;


interface IMilestone
{

    public function addIssue(IIssue $issue);

    public function getIssue(): array;

}