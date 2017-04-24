<?php
namespace AppBundle\Util;

/**
 * Class FourCardPokerScoreCalculator
 * @package AppBundle\Util
 */
class FourCardPokerScoreCalculator extends PokerScoreCalculatorBase
{
    const HIGH_CARD = 0;
    const ONE_PAIR = 1;
    const TWO_PAIR = 2;
    const STRAIGHT = 3;
    const FLUSH = 4;
    const THREE_KIND = 5;
    const STRAIGHT_FLUSH = 6;
    const FOUR_KIND = 7;

    const FULL_HOUSE = null;
    const ROYAL_FLUSH = null;

    protected const INTERNAL_SCORE_ORDER = [
        self::FOUR_KIND,
        self::STRAIGHT_FLUSH,
        self::STRAIGHT,
        self::FLUSH,
        self::HIGH_CARD,
        self::ONE_PAIR,
        self::TWO_PAIR,
        null,
        self::THREE_KIND
    ];

    protected const ACE_LOW_STRAIGHT_HEX = 0x401C;

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

        $v = $v % 15 - (($s / ($s & -$s) == 15) || ($s == static::ACE_LOW_STRAIGHT_HEX) ? 2 : 0);
        $v -= ($cardSuits[0] == $tmpSuitBitwise) * 1;

        return $v;
    }
}
