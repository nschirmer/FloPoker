<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use PlayingCardBundle\Util\CardInterface;
use PlayingCardBundle\Util\HandInterface;

/**
 * PlayerHand
 */
class PlayerHand implements HandInterface, PlayerHandInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $score = 0;

    /**
     * @var integer
     */
    private $bet;

    /**
     * @var CardInterface[]
     */
    private $cards;

    /**
     * @var Player
     */
    private $player;

    /**
     * @var Game
     */
    private $game;

    /**
     * @var boolean
     */
    private $won = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return PlayerHandInterface
     */
    public function setScore(int $score): PlayerHandInterface
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * Set bet
     *
     * @param integer $bet
     *
     * @return PlayerHandInterface
     */
    public function setBet(int $bet): PlayerHandInterface
    {
        $this->bet = $bet;

        return $this;
    }

    /**
     * Get bet
     *
     * @return integer
     */
    public function getBet(): int
    {
        return $this->bet;
    }

    /**
     * Add card
     *
     * @param CardInterface $card
     * @return PlayerHandInterface
     */
    public function addCard(CardInterface $card): PlayerHandInterface
    {
        $this->cards[] = $card;
        $card->setHand($this);

        return $this;
    }

    /**
     * Remove card
     *
     * @param CardInterface $card
     * @return PlayerHandInterface
     */
    public function removeCard(CardInterface $card): PlayerHandInterface
    {
        $this->cards->removeElement($card);

        return $this;
    }

    /**
     * Get cards
     *
     * @return CardInterface[]
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * Set player
     *
     * @param PlayerInterface $player
     * @return PlayerHandInterface
     */
    public function setPlayer(PlayerInterface $player = null): PlayerHandInterface
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return PlayerInterface
     */
    public function getPlayer(): PlayerInterface
    {
        return $this->player;
    }

    /**
     * Set game
     *
     * @param GameInterface $game
     * @return PlayerHandInterface
     */
    public function setGame(GameInterface $game = null): PlayerHandInterface
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return GameInterface
     */
    public function getGame(): GameInterface
    {
        return $this->game;
    }

    /**
     * @return string[]
     */
    public function getCardSuits(): array
    {
        $suits = array_map(function (CardInterface $card) {
            return $card->getSuit();
        }, $this->cards->toArray());

        sort($suits);

        return $suits;
    }

    /**
     * @return string[]
     */
    public function getCardRanks(): array
    {
        $ranks = array_map(function (CardInterface $card) {
            return $card->getRank();
        }, $this->cards->toArray());

        sort($ranks);

        return $ranks;
    }

    /**
     * Set won
     *
     * @param boolean $won
     *
     * @return PlayerHand
     */
    public function setWon(bool $won)
    {
        $this->won = $won;

        return $this;
    }

    /**
     * Get won
     *
     * @return boolean
     */
    public function getWon(): bool
    {
        return $this->won;
    }
}
