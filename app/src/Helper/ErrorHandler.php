<?php

namespace TicTacToe\Helper;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class ErrorHandler
 * @package TicTacToe\Helper
 */
class ErrorHandler
{
    /**
     * @param Request $request
     * @param Response $response
     * @param \Throwable $e
     * @return Response
     */
    public function __invoke(Request $request, Response $response, \Throwable $e): Response
    {
        $data = [
            'status' => $e->getCode(),
            'title' => $e->getMessage(),
            'meta' => [
                'requestBody' => $request->getParsedBody(),
            ]
        ];
        return $response->withStatus($e->getCode())->withHeader('Content-Type', 'application/json')->withJson($data);
    }
}
