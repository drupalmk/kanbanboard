<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 21/09/2018
 * Time: 14:52
 */

namespace KanbanBoard\Entity;

class IssueState
{

    private $state;

    public function __construct($state)
    {
        $allowedValues = $this->getAllowedStates();
        if (is_string($state)) {
            if (!in_array($state, $allowedValues)) {
                throw new \Exception(
                  'Invalid state label: ' . $state . '. Allowed labels: '
                   . implode(', ', $allowedValues)
                );
            }

            $this->state = (int)array_search($state, $allowedValues);

        } else {
            if (is_numeric($state)) {
                $state = (int)$state;
                if (!array_key_exists($state, $allowedValues)) {
                    throw new \Exception(
                      'Invalid state value: ' . $state . '. Allowed values: '
                       . implode(', ', array_keys($allowedValues))

                    );
                }
                $this->state = $state;
            }
        }

    }

    public function getAllowedStates()
    {
        return [
          self::Queued => 'queued',
          self::Active => 'active',
          self::Completed => 'completed',
        ];
    }

    public function __toString()
    {
        $allowedValues = $this->getAllowedStates();

        return $allowedValues[$this->state];
    }

    const Queued = 1;

    const Active = 2;

    const Completed = 3;

}