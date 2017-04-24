<?php
namespace PlayingCardBundle\Util;

interface HandInterface
{
    public function addCard(CardInterface $card);

    public function getCards();

    public function getScore();

    public function setScore(int $score);

    public function getCardSuits(): array;

    public function getCardRanks(): array;
}
