<?php

namespace TicTacToe\Service;

use TicTacToe\Gateway\GameGateway;
use TicTacToe\Helper\GameGatewayTrait;
use TicTacToe\Helper\GameHydratorTrait;
use TicTacToe\Helper\GameValidatorTrait;
use TicTacToe\Model\Move;
use TicTacToe\Model\Game;
use TicTacToe\Validator\GameValidator;
use Zend\Hydrator\HydratorInterface;

/**
 * Class MoveService
 * @package TicTacToe\Service
 */
class MoveService
{
    use GameGatewayTrait;
    use GameValidatorTrait;
    use GameHydratorTrait;

    /** @var HydratorInterface $moveHydrator */
    protected $moveHydrator;

    /**
     * GameService constructor.
     * @param GameValidator $gameValidator
     * @param GameGateway $gameGateway
     * @param HydratorInterface $gameHydrator
     * @param HydratorInterface $moveHydrator
     */
    public function __construct(
        GameValidator $gameValidator,
        GameGateway $gameGateway,
        HydratorInterface $gameHydrator,
        HydratorInterface $moveHydrator
    ) {
        $this->setGameValidator($gameValidator);
        $this->setGameGateway($gameGateway);
        $this->setGameHydrator($gameHydrator);
        $this->setMoveHydrator($moveHydrator);
    }

    /**
     * @param Move $move
     * @return Move
     * @throws \Exception
     */
    public function makeMove(Move $move): Move
    {
        /** @var Game $game */
        $game = $this->getGameHydrator()->hydrate($this->getGameGateway()->find($move->getGameId()), new Game());

        $this->getGameValidator()->validateMove($game, $move);

        $this->updateBoard($game, $move);
        $this->updatePlayerToMove($game, $move);
        $this->setWinner($game);

        if (!$this->getGameGateway()->createOrUpdate($this->getGameHydrator()->extract($game))) {
            throw new \Exception('Something went wrong. Try again', 500);
        };

        return $move;
    }

    /**
     * @param Game $game
     * @param Move $move
     */
    protected function updateBoard(Game &$game, Move $move): void
    {
        $board = $game->getBoard();

        $board[$move->getBoardPosition()] = $move->getPlayer();

        $game->setBoard($board);
    }

    /**
     * @param Game $game
     * @param Move $move
     */
    protected function updatePlayerToMove(Game &$game, Move $move): void
    {
        $players = [$game->getPlayerOne(), $game->getPlayerTwo()];

        if (!is_null($game->getPlayerToMove())) {
            unset($players[array_search($game->getPlayerToMove(), $players)]);
            $game->setPlayerToMove(implode('', $players));
        } else {
            unset($players[array_search($move->getPlayer(), $players)]);
            $game->setPlayerToMove(implode('', $players));
        }
    }

    /**
     * @param Game $game
     */
    protected function setWinner(Game &$game): void
    {
        foreach ($this->getGameValidator()->getWinnerBoards() as $winnerBoard) {
            $players = array_unique(array_intersect_key($game->getBoard(), array_flip($winnerBoard)));
            if (count($players) === 1 && !in_array(null, $players)) {
                $winner = implode('', $players);
                $game->setWinner($winner);
                break;
            }
        }
    }

    /**
     * @return HydratorInterface
     */
    public function getMoveHydrator(): HydratorInterface
    {
        return $this->moveHydrator;
    }

    /**
     * @param HydratorInterface $moveHydrator
     * @return MoveService
     */
    public function setMoveHydrator(HydratorInterface $moveHydrator): MoveService
    {
        $this->moveHydrator = $moveHydrator;

        return $this;
    }
}
