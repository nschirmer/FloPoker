<?php
namespace PlayingCardBundle\Service;

use PlayingCardBundle\Util\DeckInterface;
use PlayingCardBundle\Util\HandInterface;

interface ScoringServiceInterface
{
    public function getScore(HandInterface $hand);

    public function getScoreText(HandInterface $hand);
}
