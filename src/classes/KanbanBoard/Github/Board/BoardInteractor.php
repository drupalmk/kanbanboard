<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 18/09/2018
 * Time: 13:50
 */

namespace KanbanBoard\Github\Board;

use KanbanBoard\Board\BoardInteractorInterface;
use KanbanBoard\Client\ClientInterface;
use KanbanBoard\Github\Entity\Issue;
use KanbanBoard\KanbanBoard\Github\Entity\Milestone;

/**
 * The purpose of this class is to map API data into entites.
 * More like Mapper, maybe "Interactor" is not best name for this.
 *
 * @package KanbanBoard\Github\Board
 */
class BoardInteractor implements BoardInteractorInterface
{

    /**
     * @var \KanbanBoard\Client\ClientInterface
     */
    private $client;

    /**
     * @param \KanbanBoard\Client\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function getMilestones(): array
    {
        $milestones = [];
        $milestonesData = $this->client->getMilestones();
        $issues = $this->client->getIssues();

        foreach ($milestonesData as $repository => $repositoryMilestones) {
            foreach ($repositoryMilestones as $milestoneData) {
                $id = $milestoneData['id'];
                $milestone = new Milestone($id);
                $milestone->setTitle($milestoneData['title']);

                if (isset($issues[$id]) && !empty($issues[$id])) {
                    foreach ($issues[$id] as $issueData) {
                        $issue = new Issue($issueData['id']);
                        $issue->setTitle($issueData['title']);
                        $milestone->addIssue($issue);
                    }
                }

                $milestones[] = $milestone;
            }
        }
        return $milestones;
    }
}