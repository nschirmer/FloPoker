<?php
namespace AppBundle\Entity;

interface GameInterface
{
    public function getId();

    public function setNumCards($numCards);

    public function getNumCards();

    public function setBetMax($betMax);

    public function getBetMax();

    public function setBetMin($betMin);

    public function getBetMin();

    public function getCreatedAt();

    public function setCreatedAt($createdAt);

    public function addPlayer(PlayerInterface $player);

    public function hasPlayer(PlayerInterface $player): bool;

    public function addPlayerHand(PlayerHand $playerHand);

    public function removePlayerHand(PlayerHand $playerHand);

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection;
     */
    public function getPlayerHands();

    public function setActive(bool $active);

    public function isActive();

    public function getPlayerHandIds();

    public function getPlayerHandWithHighestScore(): PlayerHand;

    public function getPlayerHandsSortedByScore();
}
