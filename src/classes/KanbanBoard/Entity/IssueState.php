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

    private static $allowedState = [
      self::Queued => 'queued',
      self::Active => 'active',
      self::Completed => 'completed',
    ];

    /**
     * IssueState constructor.
     *
     * @param mixed $state
     *    Numeric value or state label.
     *
     * @throws \Exception
     */
    public function __construct($state)
    {
        $allowedValues = self::$allowedState;
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
                $state = (int) $state;
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

    /**
     * @return string
     *    State label.
     */
    public function __toString()
    {
        return self::$allowedState[$this->state];
    }

    const Queued = 1;

    const Active = 2;

    const Completed = 3;

}