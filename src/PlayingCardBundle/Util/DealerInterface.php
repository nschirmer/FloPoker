<?php
namespace PlayingCardBundle\Util;

use PlayingCardBundle\Service\ScoringServiceInterface;

interface DealerInterface
{
    public function setScoringService(ScoringServiceInterface $scoringService): DealerInterface;

    public function getScoringService();

    public function getDeck(): DeckInterface;

    public function setDeck(DeckInterface $deck): DealerInterface;

    public function shuffleCards(): DealerInterface;

    public function drawCard(): CardInterface;

    public function deal(int $cardsPerHand, HandInterface ...$hands);

    public function score(HandInterface ...$hands);

    public function numCardsInDeck(): int;

    public function getRemainingCards(): array;

    public function resetDeck(): DealerInterface;
}
