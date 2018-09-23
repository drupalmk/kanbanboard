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
use KanbanBoard\Entity\IssueInterface;
use KanbanBoard\Entity\IssueState;
use KanbanBoard\Entity\MilestoneInterface;
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
                $this->setMilestoneProgress($milestone, $milestoneData);

                if (isset($issues[$id]) && !empty($issues[$id])) {
                    foreach ($issues[$id] as $issueData) {
                        $issue = new Issue($issueData['id']);
                        $issue->setTitle($issueData['title']);
                        $this->setIssueState($issue, $issueData);
                        $milestone->addIssue($issue);
                    }
                }

                $milestones[] = $milestone;
            }
        }
        return $milestones;
    }

    private function setMilestoneProgress(MilestoneInterface $milestone, $data) {
        $complete = $data['closed_issues'];
        $remaining = $data['open_issues'];
        $total = $complete + $remaining;
        $percent = 0;
        if ($total > 0) {
            $percent = ($complete || $remaining) ? round(
                $complete / $total * 100
            ) : 0;
        }

        $milestone->setProgress($percent);
    }

    private function setIssueState(IssueInterface $issue, array $issueData) {
        $stateLabel = $issueData['state'];
        $assignee = $issueData['assignee'];
        $state = null;

        switch ($stateLabel) {
            case 'open':
                $state = $assignee ? IssueState::active() : IssueState::queued();
                break;
            case 'closed':
                $state = IssueState::completed();
                break;
            default:
                throw new \Exception('Unsupported issue state: ' . $stateLabel);
        }

        $issue->setState($state);
    }
}