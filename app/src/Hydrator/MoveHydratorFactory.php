<?php

namespace TicTacToe\Hydrator;

use GeneratedHydrator\Configuration;
use Slim\Container;
use TicTacToe\Model\Move;
use Zend\Hydrator\HydratorInterface;

/**
 * Class MoveHydratorFactory
 * @package TicTacToe\Hydrator
 */
class MoveHydratorFactory
{
    /**
     * @param Container $container
     * @return HydratorInterface
     */
    public function __invoke(Container $container): HydratorInterface
    {
        $config = new Configuration(Move::class);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        return new $hydratorClass;
    }
}
