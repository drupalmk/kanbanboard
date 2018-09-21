<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 12:41
 */

namespace KanbanBoard\KanbanBoard\Github\Entity;

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
     * @var array
     */
    private $issues;

    /**
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = (int) $id;
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
     * @inheritdoc
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
     * @inheritdoc
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
        if ($name == 'issues') {
            return $this->getIssues();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

}