<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;

/**
 * Game
 */
class Game implements GameInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $numCards;

    /**
     * @var integer
     */
    private $betMax;

    /**
     * @var integer
     */
    private $betMin;

    /**
     * @var boolean
     */
    private $active = true;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var Collection
     */
    private $player_hands;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->player_hands = new ArrayCollection();
        $this->createdAt = new \DateTime();
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
     * Set numCards
     *
     * @param integer $numCards
     *
     * @return Game
     */
    public function setNumCards($numCards)
    {
        $this->numCards = $numCards;

        return $this;
    }

    /**
     * Get numCards
     *
     * @return integer
     */
    public function getNumCards()
    {
        return $this->numCards;
    }

    /**
     * Set betMax
     *
     * @param integer $betMax
     *
     * @return Game
     */
    public function setBetMax($betMax)
    {
        $this->betMax = $betMax;

        return $this;
    }

    /**
     * Get betMax
     *
     * @return integer
     */
    public function getBetMax()
    {
        return $this->betMax;
    }

    /**
     * Set betMin
     *
     * @param integer $betMin
     *
     * @return Game
     */
    public function setBetMin($betMin)
    {
        $this->betMin = $betMin;

        return $this;
    }

    /**
     * Get betMin
     *
     * @return integer
     */
    public function getBetMin()
    {
        return $this->betMin;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add player
     *
     * @param PlayerInterface $player
     *
     * @return Game
     */
    public function addPlayer(PlayerInterface $player)
    {
        $playerHand = new PlayerHand;
        $playerHand->setPlayer($player);

        return $this->addPlayerHand($playerHand);
    }

    /**
     * @param PlayerInterface $player
     * @return boolean
     */
    public function hasPlayer(PlayerInterface $player): bool
    {
        foreach ($this->getPlayerHands() as $hand) {
            if ($hand->getPlayer() == $player) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add playerHand
     *
     * @param PlayerHand $playerHand
     *
     * @return Game
     */
    public function addPlayerHand(PlayerHand $playerHand)
    {
        $this->player_hands[] = $playerHand;

        $playerHand->setGame($this);

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

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Game
     */
    public function setActive(bool $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return integer[]
     */
    public function getPlayerHandIds(): array
    {
        return $this->getPlayerHands()->map(function (PlayerHand $hand) {
            return $hand->getId();
        })->toArray();
    }

    /**
     * @return PlayerHand
     */
    public function getPlayerHandWithHighestScore(): PlayerHand
    {
        return $this->getPlayerHandsSortedByScore()->first();
    }

    /**
     * @return ArrayCollection
     */
    public function getPlayerHandsSortedByScore(): ArrayCollection
    {
        $criteria = Criteria::create()
            ->orderBy(["score" => Criteria::DESC]);

        return $this->getPlayerHands()->matching($criteria);
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Game
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
