<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:40
 */

namespace KanbanBoard\Entity;


interface EntityInterface
{
    /**
     * @return int
     */
    public function getId() : int;

    /**
     * @return string
     */
    public function getTitle() : string;

    /**
     * @param string $title
     */
    public function setTitle(string $title);

    /**
     * @param string $url
     *
     * @return void
     */
    public function setUrl(string $url);

    /**
     * @return string
     */
    public function getUrl() : string;
}