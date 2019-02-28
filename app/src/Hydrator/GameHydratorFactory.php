<?php

namespace TicTacToe\Hydrator;

use GeneratedHydrator\Configuration;
use Slim\Container;
use TicTacToe\Model\Game;
use Zend\Hydrator\HydratorInterface;

/**
 * Class GameHydratorFactory
 * @package TicTacToe\Hydrator
 */
class GameHydratorFactory
{
    /**
     * @param Container $container
     * @return HydratorInterface
     */
    public function __invoke(Container $container): HydratorInterface
    {
        $config = new Configuration(Game::class);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        return new $hydratorClass;
    }
}
