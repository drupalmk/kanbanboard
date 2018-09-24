<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 14:02
 */

namespace KanbanBoard\Config;

interface OAuthInterface
{
    /**
     * @return string
     */
    public function getClientId() : string;

    /**
     * @return string
     */
    public function getClientSecret() : string;

    /**
     * @return string
     */
    public function getRedirectUrl() : string;
}