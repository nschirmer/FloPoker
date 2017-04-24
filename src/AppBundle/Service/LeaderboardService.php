<?php
namespace AppBundle\Service;

use AppBundle\Entity\PlayerHandInterface;
use AppBundle\Entity\PlayerInterface;
use AppBundle\Repository\GameRepositoryInterface;
use AppBundle\Repository\PlayerRepositoryInterface;

class LeaderboardService
{
    /**
     * @var GameRepositoryInterface
     */
    private $gameRepository;

    /**
     * @var PlayerRepositoryInterface
     */
    private $playerRepository;

    public function __construct(
        GameRepositoryInterface $gameRepository = null,
        PlayerRepositoryInterface $playerRepository = null
    ) {
        if (null !== $gameRepository) {
            $this->setGameRepository($gameRepository);
        }

        if (null !== $playerRepository) {
            $this->setPlayerRepository($playerRepository);
        }
    }

    /**
     * @return GameRepositoryInterface
     */
    public function getGameRepository()
    {
        return $this->gameRepository;
    }

    /**
     * @param GameRepositoryInterface $gameRepository
     */
    public function setGameRepository(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * @return PlayerRepositoryInterface
     */
    public function getPlayerRepository()
    {
        return $this->playerRepository;
    }

    /**
     * @param PlayerRepositoryInterface $playerRepository
     */
    public function setPlayerRepository(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * @param int $limit
     * @return PlayerInterface[]
     */
    public function getPlayersWithMostCoins(int $limit = 10)
    {
        return $this->playerRepository->findSomeOrderedByMostCoins($limit);
    }

    /**
     * @param int $limit
     * @return PlayerInterface[]
     */
    public function getPlayersWithMostWins(int $limit = 10)
    {
        return $this->playerRepository->findSomeOrderedByMostHandsWon($limit);
    }

    /**
     * @param int $limit
     * @return PlayerHandInterface[]
     */
    public function getBestWinningHands(int $limit = 10)
    {
        return $this->gameRepository->findBestWinningHands($limit);
    }
}
