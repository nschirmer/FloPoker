<?php
namespace AppBundle\Util;

use PlayingCardBundle\Util\HandInterface;

interface ScoreCalculatorInterface
{
    public static function getScoreFromHand(HandInterface $hand): int;

    public static function getScoreTextFromHand(HandInterface $hand): string;

    public static function getScoreTextFromScore(int $score): string;
}