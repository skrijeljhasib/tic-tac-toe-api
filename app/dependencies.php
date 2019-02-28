<?php

use Slim\Views\PhpRenderer;
use TicTacToe\Gateway\GameGatewayFactory;
use TicTacToe\Gateway\RedisFactory;
use TicTacToe\Helper\ErrorHandler;
use TicTacToe\Hydrator\GameHydratorFactory;
use TicTacToe\Hydrator\MoveHydratorFactory;
use TicTacToe\Service\GameServiceFactory;
use TicTacToe\Service\MoveServiceFactory;
use TicTacToe\Validator\GameValidator;

$container = $app->getContainer();

$container['renderer'] = new PhpRenderer(__DIR__ . '/../front');
$container['errorHandler'] = function () {
    return new ErrorHandler();
};
$container['redis'] = new RedisFactory();
$container['gameHydrator'] = new GameHydratorFactory();
$container['moveHydrator'] = new MoveHydratorFactory();
$container['gameGateway'] = new GameGatewayFactory();
$container['gameValidator'] = new GameValidator();
$container['gameService'] = new GameServiceFactory();
$container['moveService'] = new MoveServiceFactory();
