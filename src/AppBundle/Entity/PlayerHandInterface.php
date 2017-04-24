<?php
namespace AppBundle\Entity;

use PlayingCardBundle\Util\CardInterface;

interface PlayerHandInterface
{
    public function getId();

    public function setScore(int $score): PlayerHandInterface;

    public function getScore(): int;

    public function setBet(int $bet): PlayerHandInterface;

    public function getBet(): int;

    public function addCard(CardInterface $card): PlayerHandInterface;

    public function removeCard(CardInterface $card): PlayerHandInterface;

    public function getCards();

    public function setPlayer(PlayerInterface $player = null): PlayerHandInterface;

    public function getPlayer(): PlayerInterface;

    public function setGame(GameInterface $game = null): PlayerHandInterface;

    public function getGame(): GameInterface;

    public function getCardSuits(): array;

    public function getCardRanks(): array;

    public function setWon(bool $won);

    public function getWon(): bool;
}
