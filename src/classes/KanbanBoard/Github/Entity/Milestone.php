<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:41
 */

namespace KanbanBoard\Github\Entity;

use KanbanBoard\Entity\IssueInterface;
use KanbanBoard\Entity\MilestoneInterface;

class Milestone implements MilestoneInterface
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
     * @var int
     */
    private $progress;

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $issues;

    /**
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = (int) $id;
        $this->issues = [];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @param int $progress
     *
     * @return void
     */
    public function setProgress(int $progress)
    {
        $this->progress = $progress;
    }

    /**
     * @return int
     */
    public function getProgress(): int
    {
        return $this->progress;
    }

    /**
     * {@inheritdoc}
     */
    public function addIssue(IssueInterface $issue)
    {
        /**
         * Here for few seconds I had an idea to check if same issue already exists in the list.
         * Figured out that PHP still do not have __equals() method or similar.
         * Deal with it.
         */
        $this->issues[] = $issue;
    }

    /**
     * {@inheritdoc}
     */
    public function getIssues(): array
    {
        return $this->issues;
    }

    /**
     * @param string $name
     *    Property name.
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }
}