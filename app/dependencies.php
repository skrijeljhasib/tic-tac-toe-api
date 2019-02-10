<?php

use GeneratedHydrator\Configuration;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;
use TicTacToe\Gateway\GameGateway;
use TicTacToe\Model\Move;
use TicTacToe\Model\Game;
use TicTacToe\Service\MoveService;
use TicTacToe\Service\GameService;
use TicTacToe\Validator\GameValidator;

$container = $app->getContainer();

$container['renderer'] = new PhpRenderer(__DIR__ . '/../front');

$container['errorHandler'] = function ($container) {
    return function (Request $request, Response $response, \Throwable $e) use ($container) {
        $data = [
            'status' => $e->getCode(),
            'title' => $e->getMessage(),
            'meta' => [
                'requestBody' => $request->getParsedBody(),
            ]
        ];
        return $response->withStatus($e->getCode())->withHeader('Content-Type', 'application/json')->withJson($data);
    };
};

$container['redis'] = new Redis();

$container['gameHydrator'] = function () {
    $config = new Configuration(Game::class);
    $hydratorClass = $config->createFactory()->getHydratorClass();
    return new $hydratorClass;
};

$container['moveHydrator'] = function () {
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

$container['gameValidator'] = new GameValidator();

$container['gameService'] = function ($container) {
    return new GameService(
        $container->get('gameValidator'),
        $container->get('gameGateway'),
        $container->get('gameHydrator')
    );
};

$container['moveService'] = function ($container) {
    return new MoveService(
        $container->get('gameValidator'),
        $container->get('gameGateway'),
        $container->get('gameHydrator'),
        $container->get('moveHydrator')
    );
};
