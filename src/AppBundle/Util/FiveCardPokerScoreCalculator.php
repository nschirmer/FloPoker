<?php
namespace AppBundle\Util;

/**
 * Class FiveCardPokerScoreCalculator
 * @package AppBundle\Util
 */
class FiveCardPokerScoreCalculator extends PokerScoreCalculatorBase
{
    const HIGH_CARD = 0;
    const ONE_PAIR = 1;
    const TWO_PAIR = 2;
    const THREE_KIND = 3;
    const STRAIGHT = 4;
    const FLUSH = 5;
    const FULL_HOUSE = 6;
    const FOUR_KIND = 7;
    const STRAIGHT_FLUSH = 8;
    const ROYAL_FLUSH = 9;

    protected const INTERNAL_SCORE_ORDER = [
        self::FOUR_KIND,
        self::STRAIGHT_FLUSH,
        self::STRAIGHT,
        self::FLUSH,
        self::HIGH_CARD,
        self::ONE_PAIR,
        self::TWO_PAIR,
        self::ROYAL_FLUSH,
        self::THREE_KIND,
        self::FULL_HOUSE
    ];

    protected const ACE_LOW_STRAIGHT_HEX = 0x403c;

    /**
     * @param int $v
     * @param int $s
     * @param array $cardSuits
     * @return int
     */
    protected static function calculateInternalHandValue(int $v, int $s, array $cardSuits): int
    {
        $tmpSuitBitwise = 0;
        for ($i = 1; $i < count($cardSuits); $i++) {
            $tmpSuitBitwise |= $cardSuits[$i];
        }
        $v = $v % 15 - (($s / ($s & -$s) == 31) || ($s == static::ACE_LOW_STRAIGHT_HEX) ? 3 : 1);
        $v -= ($cardSuits[0] == $tmpSuitBitwise) * (($s == 0x7c00) ? -5 : 1);

        return $v;
    }
}
