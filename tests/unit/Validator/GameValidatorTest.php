<?php

namespace TicTacToe\UnitTest\Validator;

use PHPUnit\Framework\TestCase;
use TicTacToe\Model\Move;
use TicTacToe\Model\Game;
use TicTacToe\Validator\GameValidator;

/**
 * Class GameValidatorTest
 * @package TicTacToe\UnitTest\Validator
 */
class GameValidatorTest extends TestCase
{
    /** @var GameValidator $gameValidator */
    protected $gameValidator;

    protected function setUp()
    {
        $this->gameValidator = new GameValidator();
    }

    /**
     * @dataProvider validateNewGameDataProvider
     * @param $game
     * @param $exceptionClass
     * @param $exceptionMessage
     * @param $errorCode
     * @throws \Exception
     */
    public function testValidateNewGameWillThrowException($game, $exceptionClass, $exceptionMessage, $errorCode)
    {
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);
        $this->expectExceptionCode($errorCode);

        $this->gameValidator->validateNewGame($game);
    }

    /**
     * @dataProvider validateActionProvider
     * @param $game
     * @param $move
     * @param $exceptionClass
     * @param $exceptionMessage
     * @param $errorCode
     * @throws \Exception
     */
    public function testValidateActionWillThrowException($game, $move, $exceptionClass, $exceptionMessage, $errorCode)
    {
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);
        $this->expectExceptionCode($errorCode);

        $this->gameValidator->validateMove($game, $move);
    }

    public function validateNewGameDataProvider()
    {
        return [
            'No ID' => [
                (new Game()),
                \Exception::class,
                'ID of the game has not been set',
                400
            ],
            'No Player One' => [
                (new Game())->setId('1'),
                \Exception::class,
                'Player One has not been set',
                400
            ],
            'No Player Two' => [
                (new Game())->setId('1')->setPlayerOne('Test1'),
                \Exception::class,
                'Player Two has not been set',
                400
            ],
            'Winner is set' => [
                (new Game())->setId('1')->setPlayerOne('Test1')->setPlayerTwo('Test2')->setWinner('Test1'),
                \Exception::class,
                'Winner can not been set',
                405
            ],
            'PlayerToMove is set' => [
                (new Game())->setId('1')->setPlayerOne('Test1')->setPlayerTwo('Test2')->setPlayerToMove('Test1'),
                \Exception::class,
                'Player to move can not been set',
                405
            ],
            'Bad board' => [
                (new Game())->setId('1')->setPlayerOne('Test1')->setPlayerTwo('Test2')->setBoard(['test', null]),
                \Exception::class,
                'The game board has not been correct initialized',
                400
            ],
        ];
    }

    public function validateActionProvider()
    {
        return [
            'Game already finished' => [
                (new Game())->setWinner('Test1'),
                (new Move()),
                \Exception::class,
                'This game has finished. The winner is Test1',
                400
            ],
            'Player does not exist' => [
                (new Game())->setPlayerOne('Test1')->setPlayerTwo('Test2'),
                (new Move())->setPlayer('Test3'),
                \Exception::class,
                'The player Test3 does not exist',
                400
            ],
            'Wrong turn' => [
                (new Game())->setPlayerOne('Test1')->setPlayerTwo('Test2')->setPlayerToMove('Test1'),
                (new Move())->setPlayer('Test2'),
                \Exception::class,
                'It\'s not your turn',
                400
            ],
            'Wrong board position' => [
                (new Game())->setPlayerOne('Test1')->setPlayerTwo('Test2'),
                (new Move())->setPlayer('Test1')->setBoardPosition(10),
                \Exception::class,
                'The position must be between 0 and 8',
                400
            ],
            'Board position already set' => [
                (new Game())->setPlayerOne('Test1')->setPlayerTwo('Test2')->setBoard([
                    'Test1', null, null, null, null, null, null, null, null,
                ]),
                (new Move())->setPlayer('Test1')->setBoardPosition(0),
                \Exception::class,
                'The board position is already set',
                400
            ],
        ];
    }
}
