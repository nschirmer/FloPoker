<?php
namespace PlayingCardBundle\Service;

use PlayingCardBundle\Util\DealerInterface;
use PlayingCardBundle\Util\DeckInterface;

interface DealerManagerInterface
{
    public function getDealer(
        DeckInterface $deck = null,
        ScoringServiceInterface $scoringService = null
    ): DealerInterface;
}
