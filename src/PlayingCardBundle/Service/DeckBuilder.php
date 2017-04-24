<?php
namespace PlayingCardBundle\Service;

use PlayingCardBundle\Util\Deck;
use PlayingCardBundle\Util\DeckInterface;

class DeckBuilder implements DeckBuilderInterface
{
    /**
     * @var CardGeneratorInterface
     */
    protected $cardGenerator;

    /**
     * @return DeckInterface
     */
    public function getDeck(): DeckInterface
    {
        return new Deck($this->cardGenerator);
    }

    /**
     * @param CardGeneratorInterface $cardGenerator
     * @return DeckBuilderInterface
     */
    public function setCardGenerator(CardGeneratorInterface $cardGenerator): DeckBuilderInterface
    {
        $this->cardGenerator = $cardGenerator;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardGenerator()
    {
        return $this->cardGenerator;
    }
}
