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
 *
 * @package KanbanBoard\Github\Config
 */
class Config implements ConfigInterface
{

    const GH_CLIENT_ID = 'GH_CLIENT_ID';

    const GH_CLIENT_SECRET = 'GH_CLIENT_SECRET';

    const GH_ACCOUNT_NAME = 'GH_ACCOUNT';

    const GH_REPOSITORIES = 'GH_REPOSITORIES';

    const GH_PAUSED_LABELS = 'GH_PAUSED_LABELS';

    const GH_CACHE_LOCATION = 'GH_CACHE_LOCATION';

    const GH_MULTIPLE_VALUES_SEPARATOR = '|';

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
        return getenv(self::GH_CLIENT_ID);
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return getenv(self::GH_CLIENT_SECRET);
    }

    /**
     * @return string
     */
    public function getAccountName(): string
    {
        return getenv(self::GH_ACCOUNT_NAME);
    }

    /**
     * @return array
     */
    public function getRepositoryList(): array
    {
        $names = getenv(self::GH_REPOSITORIES);

        return explode(self::GH_MULTIPLE_VALUES_SEPARATOR, $names);
    }

    /**
     * @return array
     */
    public function getPausedLabels(): array
    {
        $tags = getenv(self::GH_PAUSED_LABELS);

        return explode(self::GH_MULTIPLE_VALUES_SEPARATOR, $tags);
    }

    /**
     * Get absolute cache directory location.
     *
     * @return string
     */
    public function getCacheLocation(): string
    {
        return getenv(self::GH_CACHE_LOCATION);
    }
}