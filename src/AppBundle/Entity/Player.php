<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * User
 */
class Player implements PlayerInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $coins = 0;

    /**
     * @var Collection
     */
    private $player_hands;

    /**
     * Player constructor.
     * @param string|null $name
     */
    public function __construct(string $name = null)
    {
        $this->player_hands = new ArrayCollection();

        if (null !== $name) {
            $this->setName($name);
        }
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
     * Set name
     *
     * @param string $name
     * @return PlayerInterface
     */
    public function setName(string $name): PlayerInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set coins
     *
     * @param integer $coins
     * @return PlayerInterface
     */
    public function setCoins(int $coins): PlayerInterface
    {
        $this->coins = $coins;

        return $this;
    }

    /**
     * Get coins
     *
     * @return integer
     */
    public function getCoins(): int
    {
        return $this->coins;
    }

    /**
     * Add playerHand
     *
     * @param PlayerHand $playerHand
     *
     * @return Player
     */
    public function addPlayerHand(PlayerHand $playerHand)
    {
        $this->player_hands[] = $playerHand;

        return $this;
    }

    /**
     * Remove playerHand
     *
     * @param PlayerHand $playerHand
     */
    public function removePlayerHand(PlayerHand $playerHand)
    {
        $this->player_hands->removeElement($playerHand);
    }

    /**
     * Get playerHands
     *
     * @return ArrayCollection
     */
    public function getPlayerHands()
    {
        return $this->player_hands;
    }
}
