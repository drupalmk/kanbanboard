<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 14:26
 */

namespace KanbanBoard\Github\Config;

use Dotenv\Dotenv;
use KanbanBoard\Config\OAuthInterface;
use KanbanBoard\Config\VersionControlInterface;

class Config implements OAuthInterface, VersionControlInterface
{

    /**
     * Config constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        // TODO: Implement getClientId() method.
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        // TODO: Implement getClientSecret() method.
    }

    /**
     * @return string
     */
    public function getAccountName(): string
    {
        // TODO: Implement getAccountName() method.
    }

    /**
     * @return array
     */
    public function getRepositoryList(): array
    {
        // TODO: Implement getRepositoryList() method.
    }

    /**
     * @return array
     */
    public function getPausedTags(): array
    {
        // TODO: Implement getPausedTags() method.
    }
}