<?php
namespace AppBundle\Util;

/**
 * Class ThreeCardPokerScoreCalculator
 * @package AppBundle\Util
 */
class ThreeCardPokerScoreCalculator extends PokerScoreCalculatorBase
{
    const HIGH_CARD = 0;
    const ONE_PAIR = 1;
    const FLUSH = 2;
    const STRAIGHT = 3;
    const THREE_KIND = 4;
    const STRAIGHT_FLUSH = 5;

    const TWO_PAIR = null;
    const FOUR_KIND = null;
    const FULL_HOUSE = null;
    const ROYAL_FLUSH = null;

    protected const INTERNAL_SCORE_ORDER = [
        self::STRAIGHT,
        self::HIGH_CARD,
        self::ONE_PAIR,
        self::STRAIGHT_FLUSH,
        self::FLUSH,
        self::THREE_KIND
    ];

    protected const ACE_LOW_STRAIGHT_HEX = 0x400C;

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

        $v = $v % 15 - (($s / ($s & -$s) == 7) || ($s == static::ACE_LOW_STRAIGHT_HEX) ? 3 : 2);
        $v -= ($cardSuits[0] == $tmpSuitBitwise) * (-3);

        return $v;
    }
}
