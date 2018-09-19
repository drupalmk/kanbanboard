<?php

use KanbanBoard\Github\ServiceContainer;
use KanbanBoard\GithubClient;
use KanbanBoard\Application;

require '../../vendor/autoload.php';


$container = new ServiceContainer();
$container->compile();

$settings = $container->get('github_settings');
/** @var \KanbanBoard\GithubClient $github */
$github = $container->get('github_client');
$board = new Application($github, $settings->getRepositoryList(), $settings->getPausedTags());
$data = $board->board();
$m = new Mustache_Engine(
    ['loader' => new Mustache_Loader_FilesystemLoader('../views')]
);
echo $m->render('index', ['milestones' => $data]);
