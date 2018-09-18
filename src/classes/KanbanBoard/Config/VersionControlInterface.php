<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 14:05
 */

namespace KanbanBoard\Config;

interface VersionControlInterface
{

    /**
     * @return string
     */
    public function getAccountName() : string;

    /**
     * @return array
     */
    public function getRepositoryList() : array;

    /**
     * @return array
     */
    public function getPausedTags(): array;
}