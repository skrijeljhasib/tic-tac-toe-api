<?php

namespace TicTacToe\Gateway;

use Slim\Container;

/**
 * Class GameGatewayFactory
 * @package TicTacToe\Gateway
 */
class GameGatewayFactory
{
    /**
     * @param Container $container
     * @return GameGateway
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __invoke(Container $container): GameGateway
    {
        return new GameGateway($container->get('redis'));
    }
}
