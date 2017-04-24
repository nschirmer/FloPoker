<?php
namespace PlayingCardBundle\Service;

use PlayingCardBundle\Util\DeckInterface;

interface DeckBuilderInterface
{
    public function getDeck(): DeckInterface;

    public function setCardGenerator(CardGeneratorInterface $cardGenerator): DeckBuilderInterface;

    public function getCardGenerator();
}
