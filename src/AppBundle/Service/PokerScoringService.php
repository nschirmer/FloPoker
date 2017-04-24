<?php
namespace AppBundle\Service;

use AppBundle\Util\FiveCardPokerScoreCalculator;
use AppBundle\Util\FourCardPokerScoreCalculator;
use AppBundle\Util\ThreeCardPokerScoreCalculator;
use PlayingCardBundle\Service\ScoringServiceInterface;
use PlayingCardBundle\Util\HandInterface;

/**
 * Class PokerScoringService
 * Poker hand analysis adapted from code by subskybox
 * See: https://www.codeproject.com/articles/569271/a-poker-hand-analyzer-in-javascript-using-bit-math
 * @package AppBundle\Service
 */
class PokerScoringService implements ScoringServiceInterface
{
    /**
     * @param HandInterface $hand
     * @return int
     */
    public function getScore(HandInterface $hand): int
    {
        $numCards = count($hand->getCards());

        switch ($numCards) {
            case 5:
                return FiveCardPokerScoreCalculator::getScoreFromHand($hand);
            case 4:
                return FourCardPokerScoreCalculator::getScoreFromHand($hand);
            case 3:
                return ThreeCardPokerScoreCalculator::getScoreFromHand($hand);
        }

        return 0;
    }

    /**
     * @param HandInterface $hand
     * @return string
     */
    public function getScoreText(HandInterface $hand): string
    {
        $numCards = count($hand->getCards());

        switch ($numCards) {
            case 5:
                return FiveCardPokerScoreCalculator::getScoreTextFromScore($hand->getScore());
            case 4:
                return FourCardPokerScoreCalculator::getScoreTextFromScore($hand->getScore());
            case 3:
                return ThreeCardPokerScoreCalculator::getScoreTextFromScore($hand->getScore());
        }

        return 0;
    }
}
