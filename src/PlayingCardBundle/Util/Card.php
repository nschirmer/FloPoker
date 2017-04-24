<?php
namespace PlayingCardBundle\Util;

class Card implements CardInterface
{
    /**
     * @var string
     */
    protected $suit;

    /**
     * @var string
     */
    protected $rank;

    /**
     * @var HandInterface
     */
    protected $hand;

    /**
     * Card constructor.
     * @param string|null $suit
     * @param string|null $rank
     */
    public function __construct(string $suit = null, string $rank = null)
    {
        if (null !== $suit) {
            $this->setSuit($suit);
        }

        if (null !== $rank) {
            $this->setRank($rank);
        }
    }

    /**
     * @param string $suit
     * @return CardInterface
     */
    public function setSuit(string $suit): CardInterface
    {
        $this->suit = $suit;

        return $this;
    }

    /**
     * @return string
     */
    public function getSuit()
    {
        return $this->suit;
    }

    /**
     * @return string
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param string $rank
     * @return CardInterface
     */
    public function setRank(string $rank): CardInterface
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * @param HandInterface $hand
     * @return CardInterface
     */
    public function setHand(HandInterface $hand): CardInterface
    {
        $this->hand = $hand;

        return $this;
    }

    /**
     * @return HandInterface
     */
    public function getHand(): HandInterface
    {
        return $this->hand;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->rank . " of " . $this->suit . 's';
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
    }
}
