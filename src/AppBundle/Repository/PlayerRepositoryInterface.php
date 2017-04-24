<?php
namespace AppBundle\Repository;

use AppBundle\Entity\PlayerInterface;

interface PlayerRepositoryInterface
{
    public function save(PlayerInterface $entity);

    public function findOneBy(array $criteria, array $orderBy = null);

    public function findByNameOrCreateWithCoins(string $name, int $coins): PlayerInterface;

    public function findSomeOrderedByMostHandsWon(int $limit);

    public function findSomeOrderedByMostCoins(int $limit);
}
