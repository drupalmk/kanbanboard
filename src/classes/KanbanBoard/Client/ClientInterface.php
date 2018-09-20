<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 19/09/2018
 * Time: 15:18
 */

namespace KanbanBoard\Client;

/**
 * Ths interface is used to encapsulate Github API usage.
 * Its purpose is to replace current GithubClient class implementation.
 *
 *
 * @package KanbanBoard\Client
 */
interface ClientInterface
{

    /**
     * @return array
     */
    public function getMilestones(): array;

    /**
     * @return array
     */
    public function getIssues(): array;
}