<?php
/**
 * Created by PhpStorm.
 * User: marek.kisiel
 * Date: 21/09/2018
 * Time: 14:52
 */

namespace KanbanBoard\Entity;

/**
 * Class IssueState
 *
 * Main idea was to use SplEnum here, but it's not available in PHP7, so plan failed.
 *
 * @package KanbanBoard\Entity
 */
class IssueState
{

    /**
     * @var int
     */
    private $state;

    private static $allowedState = [
      self::Queued => 'queued',
      self::Active => 'active',
      self::Paused => 'paused',
      self::Completed => 'completed',
    ];

    private static $instancesMap = [];

    /**
     * @return \KanbanBoard\Entity\IssueState
     * @throws \Exception
     */
    public static function queued()
    {
        return self::getStateInstance(self::Queued);
    }

    /**
     * @return \KanbanBoard\Entity\IssueState
     * @throws \Exception
     */
    public static function active()
    {
        return self::getStateInstance(self::Active);
    }

    /**
     * @return \KanbanBoard\Entity\IssueState
     * @throws \Exception
     */
    public static function paused()
    {
        return self::getStateInstance(self::Paused);
    }

    /**
     * @return \KanbanBoard\Entity\IssueState
     * @throws \Exception
     */
    public static function completed()
    {
        return self::getStateInstance(self::Completed);
    }

    /**
     * @param int $state
     *
     * @return \KanbanBoard\Entity\IssueState
     *
     * @throws \Exception
     */
    private static function getStateInstance(int $state)
    {
        if (isset(self::$instancesMap[$state])) {
            return self::$instancesMap[$state];
        }

        $instance = new IssueState($state);
        self::$instancesMap[$state] = $instance;

        return $instance;
    }

    /**
     * IssueState constructor.
     *
     * @param mixed $state
     *    Numeric value or state label.
     *
     * @throws \Exception
     */
    private function __construct($state)
    {
        $allowedValues = self::$allowedState;
        if (is_string($state)) {
            if (!in_array($state, $allowedValues)) {
                throw new \Exception(
                  'Invalid state label: ' . $state . '. Allowed labels: '
                   . implode(', ', $allowedValues)
                );
            }

            $this->state = (int) array_search($state, $allowedValues);
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

    const Paused = 3;

    const Completed = 4;

}