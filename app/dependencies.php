<?php

use GeneratedHydrator\Configuration;
use TicTacToe\Gateway\GameGateway;
use TicTacToe\Model\Move;
use TicTacToe\Model\Game;
use TicTacToe\Service\MoveService;
use TicTacToe\Service\GameService;
use TicTacToe\Validator\GameValidator;

$container = $app->getContainer();

$container['redis'] = function ($container) {
    $redis = new Redis();
    return $redis;
};

$container['gameHydrator'] = function ($containter) {
    $config = new Configuration(Game::class);
    $hydratorClass = $config->createFactory()->getHydratorClass();
    return new $hydratorClass;
};

$container['moveHydrator'] = function ($containter) {
    $config = new Configuration(Move::class);
    $hydratorClass = $config->createFactory()->getHydratorClass();
    return new $hydratorClass;
};

$container['gameGateway'] = function ($container) {
    $gameGateway = new GameGateway();
    $gameGateway->setRedisHost($container->get('redisConfig')['host']);
    $gameGateway->setRedis($container->get('redis'));
    return $gameGateway;
};

$container['gameService'] = function ($container) {
    return new GameService(
        new GameValidator(),
        $container->get('gameGateway'),
        $container->get('gameHydrator')
    );
};

$container['moveService'] = function ($container) {
    return new MoveService(
        new GameValidator(),
        $container->get('gameGateway'),
        $container->get('gameHydrator'),
        $container->get('moveHydrator')
    );
};
