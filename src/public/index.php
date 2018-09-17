<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

use KanbanBoard\Authentication;
use KanbanBoard\GithubClient;
use KanbanBoard\Application;
use KanbanBoard\Utils;

require '../../vendor/autoload.php';



$containerBuilder = new ContainerBuilder();
$loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__ . '/../classes/KanbanBoard'));
$loader->load('services.yaml');
$containerBuilder->compile();
/** @var \KanbanBoard\BoardSettings $settings */
$settings = $containerBuilder->get('board_settings');


$authentication = new Authentication($settings->getClientId(), $settings->getClientSecret());
$token = $authentication->login();
$github = new GithubClient($token, $settings->getAccountName());
$board = new Application($github, $settings->getRepositoryList(), ['waiting-for-feedback']);
$data = $board->board();
$m = new Mustache_Engine(
    ['loader' => new Mustache_Loader_FilesystemLoader('../views')]
);
echo $m->render('index', ['milestones' => $data]);
