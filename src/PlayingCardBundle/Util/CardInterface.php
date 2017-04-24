<?php
namespace PlayingCardBundle\Util;

interface CardInterface
{
    public function setSuit(string $suit): CardInterface;

    public function getSuit();

    public function getRank();

    public function setRank(string $rank): CardInterface;

    public function setHand(HandInterface $hand): CardInterface;

    public function getHand(): HandInterface;

    public function __construct(string $suit = null, string $rank = null);

    public function __toString(): string;
}
