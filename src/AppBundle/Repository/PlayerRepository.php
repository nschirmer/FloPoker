<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Player;
use AppBundle\Entity\PlayerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PlayerRepository extends EntityRepository implements PlayerRepositoryInterface
{
    /**
     * @param PlayerInterface $player
     */
    public function save(PlayerInterface $player)
    {
        if (null === $player->getId()) {
            $this->getEntityManager()->persist($player);
        } else {
            $this->getEntityManager()->merge($player);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @param string $name
     * @param int $coins
     * @return PlayerInterface
     */
    public function findByNameOrCreateWithCoins(string $name, int $coins): PlayerInterface
    {
        $player = $this->findOneBy(['name' => $name]);

        if (!$player) {
            $player = new Player;
            $player->setName($name);
            $player->setCoins($coins);
        }

        return $player;
    }

    /**
     * @param int $limit
     * @return Player[]
     */
    public function findSomeOrderedByMostHandsWon(int $limit)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p, SUM(h.won) AS hands_won
                FROM AppBundle:Player p
                JOIN p.player_hands h
                WHERE h.won = 1
                GROUP BY p.id
                ORDER BY hands_won DESC'
            )->setMaxResults($limit)
            ->getResult();
    }

    /**
     * @param int $limit
     * @return Player[]
     */
    public function findSomeOrderedByMostCoins(int $limit)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AppBundle:Player p ORDER BY p.coins DESC'
            )->setMaxResults($limit)
            ->getResult();
    }
}