<?php

use KanbanBoard\Authentication;
use KanbanBoard\ServiceContainer;
use KanbanBoard\View\Board as BoardView;

require '../../vendor/autoload.php';

$container = new ServiceContainer();
$container->compile();

/** @var \KanbanBoard\Github\Board\BoardInteractor $board */
$board = $container->get('github_board');

$milestones = $board->getMilestones();
$view = new BoardView($milestones);
echo $view->render();
