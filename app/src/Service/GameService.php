<?php

namespace TicTacToe\Service;

use TicTacToe\Gateway\GameGateway;
use TicTacToe\Helper\GameGatewayTrait;
use TicTacToe\Helper\GameHydratorTrait;
use TicTacToe\Helper\GameValidatorTrait;
use TicTacToe\Model\Game;
use TicTacToe\Validator\GameValidator;
use Zend\Hydrator\HydratorInterface;

/**
 * Class GameService
 * @package TicTacToe\Service
 */
class GameService
{
    use GameGatewayTrait;
    use GameValidatorTrait;
    use GameHydratorTrait;

    /**
     * GameService constructor.
     * @param GameValidator $gameValidator
     * @param GameGateway $gameGateway
     * @param HydratorInterface $gameHydrator
     */
    public function __construct(GameValidator $gameValidator, GameGateway $gameGateway, HydratorInterface $gameHydrator)
    {
        $this->setGameValidator($gameValidator);
        $this->setGameGateway($gameGateway);
        $this->setGameHydrator($gameHydrator);
    }

    /**
     * @param string $id
     * @return Game
     * @throws \Exception
     */
    public function findGame(string $id): Game
    {
        return $this->getGameHydrator()->hydrate($this->getGameGateway()->find($id), new Game());
    }

    /**
     * @param Game $game
     * @return Game
     * @throws \Exception
     */
    public function newGame(Game $game): Game
    {
        $this->getGameValidator()->validateNewGame($game);

        if (empty($game->getCreatedAt())) {
            $game->setCreatedAt(new \DateTime());
        }

        if (!$this->getGameGateway()->createOrUpdate($this->getGameHydrator()->extract($game))) {
            throw new \Exception('Something went wrong. Try again', 500);
        };

        return $game;
    }
}
