<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:40
 */

namespace KanbanBoard\KanbanBoard\Entity;


interface IEntity
{
    /**
     * @return string
     */
    public function getText();
}