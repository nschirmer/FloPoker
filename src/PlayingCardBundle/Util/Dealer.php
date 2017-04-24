<?php
namespace PlayingCardBundle\Util;

use PlayingCardBundle\Exception\DealException;
use PlayingCardBundle\Service\ScoringServiceInterface;

class Dealer implements DealerInterface
{
    /**
     * @var DeckInterface
     */
    protected $deck;

    /**
     * @var CardInterface[]
     */
    protected $cards;

    /**
     * @var ScoringServiceInterface
     */
    protected $scoringService;

    /**
     * @return DeckInterface
     */
    public function getDeck(): DeckInterface
    {
        return $this->deck;
    }

    /**
     * @param DeckInterface $deck
     * @return DealerInterface self
     */
    public function setDeck(DeckInterface $deck): DealerInterface
    {
        $this->deck = $deck;
        $this->cards = $deck->getCards();

        return $this;
    }

    /**
     * @param ScoringServiceInterface $scoringService
     * @return DealerInterface self
     */
    public function setScoringService(ScoringServiceInterface $scoringService): DealerInterface
    {
        $this->scoringService = $scoringService;

        return $this;
    }

    /**
     * @return ScoringServiceInterface
     */
    public function getScoringService()
    {
        return $this->scoringService;
    }

    /**
     * @return DealerInterface
     */
    public function shuffleCards(): DealerInterface
    {
        shuffle($this->cards);

        return $this;
    }

    /**
     * @param int $cardsPerHand
     * @param HandInterface[] ...$hands
     * @throws DealException
     */
    public function deal(int $cardsPerHand, HandInterface ...$hands)
    {
        if (count($hands) * $cardsPerHand > $this->numCardsInDeck()) {
            throw new DealException("Not enough cards in deck to deal "
                . $cardsPerHand . " to " . count($hands) . " hand(s)");
        }

        for ($i = 0; $i < $cardsPerHand; $i++) {
            foreach ($hands as $hand) {
                $hand->addCard($this->drawCard());
            }
        }
    }

    /**
     * @param HandInterface[] ...$hands
     */
    public function score(HandInterface ...$hands)
    {
        foreach ($hands as $hand) {
            $hand->setScore($this->scoringService->getScore($hand));
        }
    }

    /**
     * @return CardInterface
     */
    public function drawCard(): CardInterface
    {
        return array_shift($this->cards);
    }

    /**
     * @return int
     */
    public function numCardsInDeck(): int
    {
        return count($this->cards);
    }

    /**
     * @return CardInterface[]
     */
    public function getRemainingCards(): array
    {
        return $this->cards;
    }

    /**
     * @param bool $shuffle
     * @return DealerInterface
     */
    public function resetDeck(bool $shuffle = true): DealerInterface
    {
        $this->cards = $this->deck->getCards();

        if ($shuffle) {
            $this->shuffleCards();
        }

        return $this;
    }
}
