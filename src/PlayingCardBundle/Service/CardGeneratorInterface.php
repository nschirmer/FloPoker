<?php
namespace PlayingCardBundle\Service;

use PlayingCardBundle\Util\CardInterface;

interface CardGeneratorInterface
{
    public function createCard($suit, $rank): CardInterface;
}
