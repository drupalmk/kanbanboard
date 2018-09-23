<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:42
 */

namespace KanbanBoard\Github\Entity;

use KanbanBoard\Entity\IssueInterface;
use KanbanBoard\Entity\IssueState;

class Issue implements IssueInterface
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var IssueState;
     */
    private $state;

    /**
     * @var string
     */
    private $url;

    /**
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param \KanbanBoard\Entity\IssueState $state
     *
     * @return void
     */
    public function setState(IssueState $state)
    {
        $this->state = $state;
    }

    /**
     * @return \KanbanBoard\Entity\IssueState
     */
    public function getState(): IssueState
    {
        return $this->state;
    }

    /**
     * @param string $url
     *
     * @return void
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

}