<?php
namespace AppBundle\Repository;

use AppBundle\Entity\GameInterface;

interface GameRepositoryInterface
{
    public function find($id);

    public function save(GameInterface $game);

    public function findBestWinningHands(int $limit = null);

    public function findAllInactive(int $limit = null);

    public function findAllInactiveForPlayerId(int $playerId, int $limit = null);
}
