<?php

namespace TicTacToe\Validator;

use TicTacToe\Model\Move;
use TicTacToe\Model\Game;

/**
 * Class GameValidator
 * @package TicTacToe\Validator
 */
class GameValidator
{
    /**
     * @return array
     */
    public function getWinnerBoards(): array
    {
        return [
            [0, 1, 2],
            [3, 4, 5],
            [6, 7, 8],
            [0, 4, 8],
            [2, 4, 6],
            [0, 3, 6],
            [1, 4, 7],
            [2, 5, 8]
        ];
    }

    /**
     * @param Game $game
     * @return void
     * @throws \Exception
     */
    public function validateNewGame(Game $game): void
    {
        if (empty($game->getId())) {
            throw new \Exception('ID of the game has not been set', 400);
        }

        if (empty($game->getPlayerOne())) {
            throw new \Exception('Player One has not been set', 400);
        }

        if (empty($game->getPlayerTwo())) {
            throw new \Exception('Player Two has not been set', 400);
        }

        if (!empty($game->getWinner())) {
            throw new \Exception('Winner can not been set', 405);
        }

        if (!empty($game->getPlayerToMove())) {
            throw new \Exception('Player to move can not been set', 405);
        }

        if (!is_array($game->getBoard()) ||
            count($game->getBoard()) !== 9 ||
            count(array_unique($game->getBoard())) !== 1 ||
            array_unique($game->getBoard())[0] !== null
        ) {
            throw new \Exception('The game board has not been correct initialized', 400);
        }
    }

    /**
     * @param Game $game
     * @param Move $move
     * @return void
     * @throws \Exception
     */
    public function validateMove(Game $game, Move $move): void
    {
        if (!is_null($winner = $game->getWinner())) {
            throw new \Exception(sprintf('This game has finished. The winner is %s', $winner), 400);
        }

        if (!in_array($move->getPlayer(), [$game->getPlayerOne(), $game->getPlayerTwo()])) {
            throw new \Exception(sprintf('The player %s does not exist', $move->getPlayer()), 400);
        }

        if (!is_null($game->getPlayerToMove()) && $game->getPlayerToMove() !== $move->getPlayer()) {
            throw new \Exception('It\'s not your turn', 400);
        }

        if ($move->getBoardPosition() > 8 || $move->getBoardPosition() < 0) {
            throw new \Exception('The position must be between 0 and 8', 400);
        }

        if (!is_null($game->getBoard()[$move->getBoardPosition()])) {
            throw new \Exception('The board position is already set', 400);
        }
    }
}
