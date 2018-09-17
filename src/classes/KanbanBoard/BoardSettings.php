<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 15/09/2018
 * Time: 19:24
 */

namespace KanbanBoard;

use Dotenv\Dotenv;

class BoardSettings
{

    public function __construct()
    {
        $dotenv = new Dotenv(__DIR__.'/../../../');
        $dotenv->load();
    }

    public function getClientId()
    {
        return getenv('GH_CLIENT_ID');
    }

    public function getClientSecret()
    {
        return getenv('GH_CLIENT_SECRET');
    }

    public function getAccountName()
    {
        return getenv('GH_ACCOUNT');
    }

    public function getRepositoryList() : array {
        $names = getenv('GH_REPOSITORIES');
        return explode('|', $names);
    }
}