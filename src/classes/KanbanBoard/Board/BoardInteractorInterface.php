<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 13:07
 */

namespace KanbanBoard\KanbanBoard\Board;

interface BoardInteractorInterface
{

    /**
     * @TODO Consider using ArrayObject / Iterator to force type hinting.
     *
     * @return array
     */
    public function getMilestones() : array;
}