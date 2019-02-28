<?php

namespace TicTacToe\Service;

use Slim\Container;

/**
 * Class GameServiceFactory
 * @package TicTacToe\Service
 */
class GameServiceFactory
{
    /**
     * @param Container $container
     * @return GameService
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __invoke(Container $container): GameService
    {
        return new GameService(
            $container->get('gameValidator'),
            $container->get('gameGateway'),
            $container->get('gameHydrator')
        );
    }
}
