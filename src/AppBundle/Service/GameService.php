<?php
namespace AppBundle\Service;

use AppBundle\Entity\Game;
use AppBundle\Entity\GameInterface;
use AppBundle\Entity\PlayerHandInterface;
use AppBundle\Entity\PlayerInterface;
use AppBundle\Repository\GameRepositoryInterface;
use AppBundle\Repository\PlayerRepositoryInterface;
use AppBundle\Util\PokerTable;
use PlayingCardBundle\Service\DealerManagerInterface;
use PlayingCardBundle\Service\DeckBuilderInterface;
use PlayingCardBundle\Service\ScoringServiceInterface;
use PlayingCardBundle\Util\DealerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class GameService
 * @package AppBundle\Service
 */
class GameService
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var DealerManagerInterface
     */
    private $dealerManager;

    /**
     * @var DeckBuilderInterface
     */
    private $deckBuilder;

    /**
     * @var GameRepositoryInterface
     */
    private $gameRepository;

    /**
     * @var PlayerRepositoryInterface
     */
    private $playerRepository;

    /**
     * @var ScoringServiceInterface
     */
    private $scoringService;

    /**
     * GameService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return GameRepositoryInterface
     */
    public function getGameRepository(): GameRepositoryInterface
    {
        return $this->gameRepository;
    }

    /**
     * @param GameRepositoryInterface $gameRepository
     * @return self
     */
    public function setGameRepository(GameRepositoryInterface $gameRepository): GameService
    {
        $this->gameRepository = $gameRepository;

        return $this;
    }

    /**
     * @return PlayerRepositoryInterface
     */
    public function getPlayerRepository(): PlayerRepositoryInterface
    {
        return $this->playerRepository;
    }

    /**
     * @param PlayerRepositoryInterface $playerRepository
     * @return self
     */
    public function setPlayerRepository(PlayerRepositoryInterface $playerRepository): GameService
    {
        $this->playerRepository = $playerRepository;

        return $this;
    }

    /**
     * @param DeckBuilderInterface $deckBuilder
     * @return self
     */
    public function setDeckBuilder(DeckBuilderInterface $deckBuilder): GameService
    {
        $this->deckBuilder = $deckBuilder;

        return $this;
    }

    /**
     * @return DeckBuilderInterface
     */
    public function getDeckBuilder(): DeckBuilderInterface
    {
        return $this->deckBuilder;
    }

    /**
     * @param DealerManagerInterface $dealerManager
     * @return GameService
     */
    public function setDealerManager(DealerManagerInterface $dealerManager): GameService
    {
        $this->dealerManager = $dealerManager;

        return $this;
    }

    /**
     * @return DealerManagerInterface
     */
    public function getDealerManager(): DealerManagerInterface
    {
        return $this->dealerManager;
    }

    /**
     * @param ScoringServiceInterface $scoringService
     * @return GameService
     */
    public function setScoringService(ScoringServiceInterface $scoringService): GameService
    {
        $this->scoringService = $scoringService;

        return $this;
    }

    /**
     * @return ScoringServiceInterface
     */
    public function getScoringService(): ScoringServiceInterface
    {
        return $this->scoringService;
    }

    /**
     * @return DealerInterface
     */
    private function getDealer(): DealerInterface
    {
        $dealer = $this->dealerManager->getDealer($this->deckBuilder->getDeck(), $this->scoringService);
        $dealer->shuffleCards();

        return $dealer;
    }

    public function getPlayer(string $playerName): PlayerInterface
    {
        return $this->playerRepository->findByNameOrCreateWithCoins(
            $playerName,
            $this->container->getParameter('app.player.starting_coins')
        );
    }

    /**
     * @param PlayerInterface $player
     * @return ConstraintViolationListInterface
     */
    public function getPlayerValidationErrors(PlayerInterface $player)
    {
        $errors = $this->container->get('validator')->validate($player);

        $errors = array_map(function ($err) {
            return $err->getMessage();
        }, iterator_to_array($errors));

        return $errors;
    }

    /**
     * @param int $gameId
     * @throws NotFoundHttpException
     * @return GameInterface
     */
    public function findGameById(int $gameId)
    {
        $game = $this->gameRepository->find($gameId);

        if (!$game instanceof GameInterface) {
            throw new NotFoundHttpException(
                'No game found for id ' . $gameId
            );
        }

        return $game;
    }

    /**
     * @param array $playerNames
     * @param int $numCards
     * @return PokerTable
     */
    public function newGameTable(array $playerNames, int $numCards): PokerTable
    {
        $game = new Game;
        $game->setBetMin($this->container->getParameter('app.game.bet_min'));
        $game->setBetMax($this->container->getParameter('app.game.bet_max'));
        $game->setNumCards($numCards);

        $table = new PokerTable($this, $game, $this->getDealer());
        foreach ($playerNames as $name) {
            $table->addPlayer($name);
        }

        $table->dealHands();
        $table->scoreHands();

        $table->save();

        return $table;
    }

    /**
     * @param GameInterface $game
     * @return PokerTable
     */
    public function loadGameTable(GameInterface $game): PokerTable
    {
        $table = new PokerTable($this, $game, $this->getDealer());

        return $table;
    }

    /**
     * @param GameInterface $game
     * @return GameService
     */
    public function saveGame(GameInterface $game)
    {
        $game->getPlayerHands()->map(function (PlayerHandInterface $hand) use ($game) {
            $this->playerRepository->save($hand->getPlayer());
        });

        $this->gameRepository->save($game);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPastGames()
    {
        return $this->gameRepository->findAllInactive();
    }

    /**
     * @param PlayerInterface $player
     * @return mixed
     */
    public function getPastGamesForPlayer(PlayerInterface $player)
    {
        return $this->gameRepository->findAllInactiveForPlayerId($player->getId());
    }
}
