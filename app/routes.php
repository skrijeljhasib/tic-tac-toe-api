<?php

use Slim\Http\Request;
use Slim\Http\Response;
use TicTacToe\Helper\JsonDecoder;
use TicTacToe\Model\Move;
use TicTacToe\Model\Game;

$app->get('/', function (Request $request, Response $response, array $args) {
    return $this->renderer->render($response, 'Index.html', $args);
});

$app->get('/v1/games/{id}', function (Request $request, Response $response, array $args) {
    $result = $this->gameHydrator->extract($this->gameService->findGame($args['id']));
    /**
     * @OA\Get(
     *     path="/games/{id}",
     *     summary="Get a game by id",
     *   @OA\Parameter(
     *     description="ID of game to fetch",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *        format="string"
     *     )
     *  ),
     *  @OA\Response(
     *     response=200,
     *     description="Show game",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Game"),
     *     )
     *  ),
     *  @OA\Response(
     *     response=404,
     *     description="Can not find Game with id {id}"
     *  )
     * )
     */
    return $response->withStatus(200)->withJson($result);
});

$app->post('/v1/games', function (Request $request, Response $response, array $args) {
    $data = JsonDecoder::toArray($request->getBody()->getContents());
    $game = $this->gameHydrator->hydrate($data, new Game());
    $result = $this->gameHydrator->extract($this->gameService->newGame($game));
    /**
     * @OA\Post(
     *     path="/games",
     *     summary="Create a new game",
     *  @OA\RequestBody(
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Game")
     *     )
     *  ),
     *  @OA\Response(
     *     response=201,
     *     description="A new game was created",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Game")
     *     )
     *  ),
     *  @OA\Response(
     *     response=400,
     *     description="ID of the game has not been set, Player One has not been set, Player Two has not been set, The game board has not been correct initialized"
     *  ),
     *  @OA\Response(
     *     response=405,
     *     description="Winner can not been set, Player to move can not been set"
     *  )
     * )
     */
    return $response->withStatus(201)->withJson($result);
});

$app->patch('/v1/games/{id}/makeMove', function (Request $request, Response $response, array $args) {
    $data = JsonDecoder::toArray($request->getBody()->getContents());
    $move = $this->moveHydrator->hydrate($data, new Move());
    $result = $this->moveHydrator->extract($this->moveService->makeMove($move));
    /**
     * @OA\Patch(
     *  path="/games/{id}/makeMove",
     *  summary="Make a move on game",
     *   @OA\Parameter(
     *     description="ID of game to update",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *        type="string",
     *        format="string"
     *     )
     *  ),
     *  @OA\RequestBody(
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Move")
     *     )
     *  ),
     *  @OA\Response(
     *     response=200,
     *     description="The board of the game was updated",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Move")
     *     )
     *  ),
     *  @OA\Response(
     *     response=404,
     *     description="Can not find Game with id {id}"
     *  ),
     *  @OA\Response(
     *     response=400,
     *     description="It is not your turn, The position must be between 0 and 8, The player does not exist, The board position is already set, There is already a winner for this game, No winner"
     *  )
     * )
     */
    return $response->withStatus(200)->withJson($result);
});
