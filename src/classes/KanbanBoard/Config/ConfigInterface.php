<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 19/09/2018
 * Time: 13:52
 */

namespace KanbanBoard\Config;

interface ConfigInterface extends OAuthInterface, VersionControlInterface
{

    /**
     * Get absolute cache directory location.
     * @return string
     */
    public function getCacheLocation() : string;
}