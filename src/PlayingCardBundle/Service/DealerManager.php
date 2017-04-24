<?php
namespace PlayingCardBundle\Service;

use PlayingCardBundle\Util\Dealer;
use PlayingCardBundle\Util\DealerInterface;
use PlayingCardBundle\Util\DeckInterface;

class DealerManager implements DealerManagerInterface
{
    public function getDealer(
        DeckInterface $deck = null,
        ScoringServiceInterface $scoringService = null
    ): DealerInterface {
        $dealer = new Dealer;

        if (null !== $deck) {
            $dealer->setDeck($deck);
        }

        if (null !== $scoringService) {
            $dealer->setScoringService($scoringService);
        }

        return $dealer;
    }
}
