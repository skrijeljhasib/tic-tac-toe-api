<?php

use Slim\Http\Request;
use Slim\Http\Response;
use TicTacToe\Helper\JsonDecoder;
use TicTacToe\Model\Move;
use TicTacToe\Model\Game;

$app->get('/', function (Request $request, Response $response, array $args) {
    return '<h1>Tic Tac Toe</h1>';
});

$app->get('/v1/games/{id}', function (Request $request, Response $response, array $args) {
    $result = $this->gameHydrator->extract($this->gameService->findGame($args['id']));
    return $response->withStatus(200)->withJson($result);
});

$app->post('/v1/games', function (Request $request, Response $response, array $args) {
    $data = JsonDecoder::toArray($request->getBody()->getContents());
    $game = $this->gameHydrator->hydrate($data, new Game());
    $result = $this->gameHydrator->extract($this->gameService->newGame($game));
    return $response->withStatus(201)->withJson($result);
});

$app->post('/v1/games/{id}/makeMove', function (Request $request, Response $response, array $args) {
    $data = JsonDecoder::toArray($request->getBody()->getContents());
    $move = $this->moveHydrator->hydrate($data, new Move());
    $result = $this->moveHydrator->extract($this->moveService->makeMove($move));
    return $response->withStatus(200)->withJson($result);
});
