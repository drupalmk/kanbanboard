<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 14:26
 */

namespace KanbanBoard\Github\Config;

use Dotenv\Dotenv;
use KanbanBoard\Config\ConfigInterface;

/**
 * Class Config
 * @TODO Really there is a need of two separate interfaces?
 *
 * @package KanbanBoard\Github\Config
 */
class Config implements ConfigInterface
{

    /**
     * Config constructor.
     */
    public function __construct($configFileDirectory)
    {
        $dotenv = new Dotenv($configFileDirectory);
        $dotenv->load();
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return getenv('GH_CLIENT_ID');
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return getenv('GH_CLIENT_SECRET');
    }

    /**
     * @return string
     */
    public function getAccountName(): string
    {
        return getenv('GH_ACCOUNT');
    }

    /**
     * @return array
     */
    public function getRepositoryList(): array
    {
        $names = getenv('GH_REPOSITORIES');

        return explode('|', $names);
    }

    /**
     * @return array
     */
    public function getPausedTags(): array
    {
        return ['waiting-for-feedback'];
    }
}