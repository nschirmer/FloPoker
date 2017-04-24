<?php
namespace PlayingCardBundle\Util;

use PlayingCardBundle\Service\CardGeneratorInterface;

interface DeckInterface
{
    public function __construct(CardGeneratorInterface $cardGeneratorInterface, array $suits = [], array $ranks = []);

    public function getCards();

    public function getSuits(): array;

    public function getRanks(): array;
}
