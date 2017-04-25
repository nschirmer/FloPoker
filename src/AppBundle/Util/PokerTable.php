<?php
namespace AppBundle\Util;

use AppBundle\Entity\GameInterface;
use AppBundle\Entity\PlayerHandInterface;
use AppBundle\Exception\InvalidBetPlacedException;
use AppBundle\Exception\InvalidPlayerAddedException;
use AppBundle\Service\GameService;
use Doctrine\Common\Collections\Collection;
use PlayingCardBundle\Util\DealerInterface;
use PlayingCardBundle\Util\HandInterface;

class PokerTable implements TableInterface
{
    /**
     * @var GameService
     */
    private $gameService;

    /**
     * @var DealerInterface
     */
    private $dealer;

    /**
     * @var GameInterface
     */
    private $game;

    /**
     * PokerTable constructor.
     * @param GameService $gameService
     * @param GameInterface $game
     * @param DealerInterface|null $dealer
     */
    public function __construct(GameService $gameService, GameInterface $game, DealerInterface $dealer = null)
    {
        $this->gameService = $gameService;
        $this->game = $game;

        if (null !== $dealer) {
            $this->dealer = $dealer;
        }
    }

    /**
     * @return GameInterface
     */
    public function getGame(): GameInterface
    {
        return $this->game;
    }

    /**
     * @param string $playerName
     * @throws InvalidPlayerAddedException
     * @return TableInterface
     */
    public function addPlayer(string $playerName): TableInterface
    {
        $player = $this->gameService->getPlayer($playerName);
        $validationErrors = $this->gameService->getPlayerValidationErrors($player);

        if (count($validationErrors) > 0) {
            throw new InvalidPlayerAddedException(implode(" ", $validationErrors));
        } elseif ($this->game->hasPlayer($player)) {
            throw new InvalidPlayerAddedException('Unique player names must be used');
        }

        if ($player->getCoins() < $this->game->getBetMin()) {
            $player->setCoins($this->game->getBetMin());
        }

        $this->game->addPlayer($player);

        return $this;
    }

    /**
     * @return TableInterface
     */
    public function dealHands(): TableInterface
    {
        $this->dealer->deal($this->game->getNumCards(), ...$this->game->getPlayerHands());

        return $this;
    }

    /**
     * @return TableInterface
     */
    public function scoreHands(): TableInterface
    {
        $this->dealer->score(...$this->game->getPlayerHands());

        return $this;
    }

    /**
     * @param int[] $bets
     * @throws InvalidBetPlacedException
     * @return TableInterface
     */
    public function placeBets(array $bets): TableInterface
    {
        if (!$this->areBetsInRange($bets)) {
            throw new InvalidBetPlacedException('An invalid bet was placed');
        }

        $this->game->getPlayerHands()->map(function (PlayerHandInterface $hand) use ($bets) {
            if (!array_key_exists($hand->getId(), $bets)) {
                throw new InvalidBetPlacedException('Each player must have a bet');
            }

            $hand->setBet($bets[$hand->getId()]);
        });

        return $this;
    }

    /**
     * @param int[] $bets
     * @return bool
     */
    private function areBetsInRange(array $bets)
    {
        foreach ($bets as $bet) {
            if (!ctype_digit($bet) || $bet > $this->game->getBetMax() || $bet < $this->game->getBetMin()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return TableInterface
     */
    public function endGame(): TableInterface
    {
        $totalPot = 0;
        $hands = $this->getScoredHands();

        $hands->map(function (PlayerHandInterface $hand) use (&$totalPot, $hands) {
            $player = $hand->getPlayer();

            if ($hand->getId() === $hands->first()->getId()) {
                return;
            }

            $totalPot += $hand->getBet();

            $player->setCoins($player->getCoins() - $hand->getBet());
        });

        $hands->first()->setWon(true);
        $hands->first()->getPlayer()->setCoins($hands->first()->getPlayer()->getCoins() + $totalPot);

        $this->game->setActive(false);

        return $this;
    }

    /**
     * @return HandInterface
     */
    public function getWinningHand(): HandInterface
    {
        return $this->game->getPlayerHandWithHighestScore();
    }

    /**
     * @return Collection
     */
    public function getScoredHands()
    {
        return $this->game->getPlayerHandsSortedByScore();
    }

    /**
     * @return int
     */
    public function getPotSize(): int
    {
        $totalPot = 0;
        $this->getScoredHands()->map(function (PlayerHandInterface $hand) use (&$totalPot) {
            $totalPot += $hand->getBet();
        });

        return $totalPot;
    }

    /**
     * @return TableInterface
     */
    public function save(): TableInterface
    {
        $this->gameService->saveGame($this->game);

        return $this;
    }
}
