<?php

use KanbanBoard\Authentication;
use KanbanBoard\GithubClient;
use KanbanBoard\Application;
use KanbanBoard\Utils;

require '../../vendor/autoload.php';

$repositories = explode('|', Utils::env('GH_REPOSITORIES'));
$authentication = new Authentication();
$token = $authentication->login();
$github = new GithubClient($token, Utils::env('GH_ACCOUNT'));
$board = new Application($github, $repositories, ['waiting-for-feedback']);
$data = $board->board();
$m = new Mustache_Engine(
    ['loader' => new Mustache_Loader_FilesystemLoader('../views')]
);
echo $m->render('index', ['milestones' => $data]);
