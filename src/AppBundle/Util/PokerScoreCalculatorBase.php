<?php
namespace AppBundle\Util;

use PlayingCardBundle\Util\HandInterface;

/**
 * Class PokerScoreCalculatorBase
 * @package AppBundle\Util
 */
abstract class PokerScoreCalculatorBase implements ScoreCalculatorInterface
{
    /**
     * @var array
     */
    protected static $ranks = [2 => 2, 3, 4, 5, 6, 7, 8, 9, 10, 'Jack' => 11, 'Queen' => 12, 'King' => 13, 'Ace' => 14];

    /**
     * @var array
     */
    protected static $suits = ['Spade' => 1, 'Club' => 2, 'Heart' => 4, 'Diamond' => 8];

    /**
     * @param HandInterface $hand
     * @return int
     */
    public static function getScoreFromHand(HandInterface $hand): int
    {
        $cardRanks = array_map(function ($rank) {
            return static::$ranks[$rank];
        }, $hand->getCardRanks());

        $cardSuits = array_map(function ($suit) {
            return static::$suits[$suit];
        }, $hand->getCardSuits());

        return static::calculatePokerHandScore($cardRanks, $cardSuits);
    }

    /**
     * @param HandInterface $hand
     * @return string
     */
    public static function getScoreTextFromHand(HandInterface $hand): string
    {
        return static::getScoreTextFromScore($hand->getScore());
    }

    /**
     * @param $score
     * @return string
     */
    public static function getScoreTextFromScore(int $score): string
    {
        $cat = $score >> 20;
        $c1 = $score >> 16 & 15;
        $c3 = $score >> 8 & 15;
        $c4 = $score >> 4 & 15;

        $ranks = array_flip(static::$ranks);

        switch ($cat) {
            default:
            case static::HIGH_CARD:
                return $ranks[$c1] . " high";
            case static::ONE_PAIR:
                return "Pair of " . $ranks[$c1] . "s";
            case static::TWO_PAIR:
                return "Two pair, " . $ranks[$c1] . "s and " . $ranks[$c3] . "s";
            case static::THREE_KIND:
                return "Three of a kind, " . $ranks[$c1] . "s";
            case static::STRAIGHT:
                return $ranks[$c1] . " high straight";
            case static::FLUSH:
                return $ranks[$c1] . " high flush";
            case static::FULL_HOUSE:
                return $ranks[$c1] .  "s full of " . $ranks[$c4] . "s";
            case static::FOUR_KIND:
                return "Four of a kind, " . $ranks[$c1] . "s";
            case static::STRAIGHT_FLUSH:
                return $ranks[$c1] . " high straight flush";
            case static::ROYAL_FLUSH:
                return "Royal flush";
        }
    }

    /**
     * @param $cardRanks
     * @param $cardSuits
     * @return int
     */
    protected static function calculatePokerHandScore($cardRanks, $cardSuits)
    {
        $d = [];
        $s = 0;
        foreach ($cardRanks as $r) {
            $s |= 1 << $r;
        }

        for ($i = $v = 0; $i < count($cardRanks); $i++) {
            $o = pow(2, $cardRanks[$i] * 4);

            if ($o !== 0) {
                $d[$cardRanks[$i]] = ($v / $o & 15) + 1;
                $v += $o * $d[$cardRanks[$i]];
            } else {
                $d[$cardRanks[$i]] = 1;
            }
        }

        $v = static::calculateInternalHandValue($v, $s, $cardSuits);

        if ($s == static::ACE_LOW_STRAIGHT_HEX) {
            $c = array_reverse(range(1, count($cardRanks)));
        } else {
            usort($cardRanks, function ($a, $b) use ($d) {
                return $d[$a] < $d[$b] ? 1 : ($d[$a] > $d[$b] ? -1 : $b - $a);
            });
            $c = $cardRanks;
        }

        $score = static::INTERNAL_SCORE_ORDER[$v] << 20;
        foreach ($c as $i => $v) {
            $score |= $v << (16 - (4 * $i));
        }

        return $score;
    }
}
