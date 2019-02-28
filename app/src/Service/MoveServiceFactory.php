<?php

namespace TicTacToe\Service;

use Slim\Container;

/**
 * Class MoveServiceFactory
 * @package TicTacToe\Service
 */
class MoveServiceFactory
{
    /**
     * @param Container $container
     * @return MoveService
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __invoke(Container $container): MoveService
    {
        return new MoveService(
            $container->get('gameValidator'),
            $container->get('gameGateway'),
            $container->get('gameHydrator'),
            $container->get('moveHydrator')
        );
    }
}
