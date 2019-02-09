<?php

namespace TicTacToe\Model;

/**
 * Class Game
 * @package TicTacToe\Model
 * @OA\Schema()
 */
class Game
{
    /**
     * @var string $id
     * @OA\Property()
     */
    protected $id = '';

    /**
     * @var string $playerOne
     * @OA\Property()
     */
    protected $playerOne = '';

    /**
     * @var string $playerTwo
     * @OA\Property()
     */
    protected $playerTwo = '';

    /**
     * @var string $winner
     * @OA\Property(readOnly = true)
     */
    protected $winner = null;

    /**
     * @var array $board
     * @OA\Property(
     *     readOnly = true,
     *     @OA\Items()
     * )
     */
    protected $board = [
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
    ];

    /**
     * @var string $playerToMove
     * @OA\Property(readOnly = true)
     */
    protected $playerToMove = null;

    /**
     * @var \DateTime $createdAt
     * @OA\Property(readOnly = true)
     */
    protected $createdAt = null;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Game
     */
    public function setId(string $id): Game
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlayerOne(): ?string
    {
        return $this->playerOne;
    }

    /**
     * @param string $playerOne
     * @return Game
     */
    public function setPlayerOne(string $playerOne): Game
    {
        $this->playerOne = $playerOne;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlayerTwo(): ?string
    {
        return $this->playerTwo;
    }

    /**
     * @param string $playerTwo
     * @return Game
     */
    public function setPlayerTwo(string $playerTwo): Game
    {
        $this->playerTwo = $playerTwo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @param string $winner
     * @return Game
     */
    public function setWinner(string $winner): Game
    {
        $this->winner = $winner;
        return $this;
    }

    /**
     * @return array
     */
    public function getBoard(): array
    {
        return $this->board;
    }

    /**
     * @param array $board
     * @return Game
     */
    public function setBoard(array $board): Game
    {
        $this->board = $board;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlayerToMove(): ?string
    {
        return $this->playerToMove;
    }

    /**
     * @param string $playerToMove
     * @return Game
     */
    public function setPlayerToMove(string $playerToMove): Game
    {
        $this->playerToMove = $playerToMove;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Game
     */
    public function setCreatedAt(\DateTime $createdAt): Game
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
