<?php

use KanbanBoard\Github\ServiceContainer;
use KanbanBoard\GithubClient;
use KanbanBoard\Application;

require '../../vendor/autoload.php';


$container = new ServiceContainer();
$container->compile();

/** @var \KanbanBoard\Github\Config\Config */
$settings = $container->get('github_settings');


//$authentication = new Authentication($settings->getClientId(), $settings->getClientSecret());
//$token = $authentication->login();
$github = new GithubClient($settings);
$board = new Application($github, $settings->getRepositoryList(), $settings->getPausedTags());
$data = $board->board();
$m = new Mustache_Engine(
    ['loader' => new Mustache_Loader_FilesystemLoader('../views')]
);
echo $m->render('index', ['milestones' => $data]);
