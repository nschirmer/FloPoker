<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Length(
     *     min = 2,
     *     max = 50,
     *     minMessage = "Player names must be at least {{ limit }} chars long.",
     *     maxMessage = "Player names cannot be longer than {{ limit }} chars."
     * )
     * @Assert\Regex(
     *     pattern = "/^[a-z0-9 ]+$/i",
     *     message = "Player names may only consist of alphanumerical chars and spaces."
     * )
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
        $this->name = trim($name);

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
