<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 23/09/2018
 * Time: 20:06
 */

namespace KanbanBoard\View;

use KanbanBoard\Entity\IssueState;
use Twig_Environment;
use Twig_Loader_Filesystem;

class Board
{
    /**
     * @var array
     */
    private $data;

    /**
     * BoardView constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        foreach ($data as $milestone) {
            /** @var \KanbanBoard\Entity\MilestoneInterface $milestone */
            $issues = $milestone->getIssues();
            if (empty($issues)) {
                continue;
            }

            $milestone->queued = [];
            $milestone->active = [];
            $milestone->completed = [];
            /** @var \KanbanBoard\Entity\IssueInterface $issue */
            foreach ($issues as $issue) {
                $state = $issue->getState();
                switch ($state) {
                    case IssueState::queued():
                        $milestone->queued[] = $issue;
                        break;
                    case IssueState::active():
                    case IssueState::paused():
                        $issue->cssClass = $state === IssueState::paused() ? 'list-group-item-warning' : 'list-group-item-info';
                        $milestone->active[] = $issue;
                        break;
                    case IssueState::completed():
                        $milestone->completed[] = $issue;
                        break;
                }
            }

            // Order by state: active issues first.
            usort($milestone->active, function ($a, $b) {
                return $a->getState() < $b->getState();
            });
        }
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render()
    {
        // @TODO Consider template directory configurable
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../../../views');
        $twig = new Twig_Environment($loader);

        return $twig->render('index.twig', array('milestones' => $this->data));
    }
}