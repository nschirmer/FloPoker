<?php
namespace AppBundle\Util;

use AppBundle\Entity\GameInterface;
use AppBundle\Service\GameService;
use PlayingCardBundle\Util\DealerInterface;
use PlayingCardBundle\Util\HandInterface;

interface TableInterface
{
    public function __construct(GameService $gameService, GameInterface $game, DealerInterface $dealer = null);

    public function getGame(): GameInterface;

    public function addPlayer(string $playerName): TableInterface;

    public function dealHands(): TableInterface;

    public function scoreHands(): TableInterface;

    public function placeBets(array $bets): TableInterface;

    public function endGame(): TableInterface;

    public function getWinningHand(): HandInterface;

    public function getScoredHands();

    public function getPotSize(): int;

    public function save(): TableInterface;
}
