<?php
namespace PlayingCardBundle\Service;

use PlayingCardBundle\Util\Card;
use PlayingCardBundle\Util\CardInterface;

class CardGenerator implements CardGeneratorInterface
{
    public function getCardInterface()
    {
        return Card::class;
    }

    public function createCard($suit, $rank): CardInterface
    {
        $cardInterface = $this->getCardInterface();

        return new $cardInterface($suit, $rank);
    }
}
