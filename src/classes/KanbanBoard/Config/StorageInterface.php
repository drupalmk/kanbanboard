<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 14:09
 */

namespace KanbanBoard\Config;

interface StorageInterface
{
    /**
     * @return \KanbanBoard\Config\StorageInterface
     */
    public function getStorage() : StorageInterface;
}