<?php
namespace AppBundle\Entity;

use PlayingCardBundle\Util\CardInterface;
use PlayingCardBundle\Util\HandInterface;

/**
 * Card
 */
class Card extends \PlayingCardBundle\Util\Card
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $handId;

    /**
     * @var string
     */
    protected $suit;

    /**
     * @var string
     */
    protected $rank;

    /**
     * @var PlayerHand
     */
    protected $hand;


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
     * Set handId
     *
     * @param integer $handId
     *
     * @return Card
     */
    public function setHandId($handId)
    {
        $this->handId = $handId;

        return $this;
    }

    /**
     * Get handId
     *
     * @return integer
     */
    public function getHandId()
    {
        return $this->handId;
    }

    /**
     * Set suit
     *
     * @param string $suit
     *
     * @return CardInterface Card
     */
    public function setSuit(string $suit): CardInterface
    {
        parent::setSuit($suit);

        return $this;
    }

    /**
     * Get suit
     *
     * @return string
     */
    public function getSuit()
    {
        return $this->suit;
    }

    /**
     * Set rank
     *
     * @param string $rank
     *
     * @return CardInterface Card
     */
    public function setRank(string $rank): CardInterface
    {
        parent::setRank($rank);

        return $this;
    }

    /**
     * Get rank
     *
     * @return string
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set hand
     *
     * @param HandInterface $hand
     *
     * @return CardInterface
     */
    public function setHand(HandInterface $hand = null): CardInterface
    {
        $this->hand = $hand;

        return $this;
    }

    /**
     * Get hand
     *
     * @return HandInterface
     */
    public function getHand(): HandInterface
    {
        return $this->hand;
    }
}
