<?php

use GeneratedHydrator\Configuration;
use TicTacToe\Gateway\GameGateway;
use TicTacToe\Model\Game;
use TicTacToe\Service\GameService;

$container = $app->getContainer();

$container['gameGateway'] = function ($container) {
    $gameGateway = new GameGateway();
    $gameGateway->setRedisHost($container->get('redisConfig')['host']);
    $gameGateway->setRedis($container->get('redis'));
    return $gameGateway;
};

$container['redis'] = function ($container) {
    $redis = new Redis();
    return $redis;
};

$container['gameHydrator'] = function ($containter) {
    $config = new Configuration(Game::class);
    $hydratorClass = $config->createFactory()->getHydratorClass();
    return new $hydratorClass;
};

$container['gameService'] = function ($container) {
    return new GameService(
        $container->get('gameGateway'),
        $container->get('gameHydrator')
    );
};