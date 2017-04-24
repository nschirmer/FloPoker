<?php
namespace AppBundle\Controller;

use AppBundle\Exception\InvalidBetPlacedException;
use AppBundle\Exception\InvalidPlayerAddedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @return Response
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $num_cards = $this->container->getParameter('app.game.num_cards');

        return $this->render('start.html.twig', ['num_cards' => $num_cards, 'name' => []]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/start", name="start")
     */
    public function startAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $num_cards = $request->request->get('num_cards');
            $playerNames = array_filter((array) $request->request->get('name'), 'strlen');

            if (!in_array($num_cards, array_keys($this->container->getParameter('app.game.types')))) {
                $this->addFlash('danger', 'You must select one of the available game types!');
            } elseif (count($playerNames) < 2) {
                $this->addFlash('warning', 'You must enter two or more player names!');
            } else {
                try {
                    $table = $this->get('app.game_service')->newGameTable($playerNames, $num_cards);

                    return $this->redirectToRoute('play', ['gameId' => $table->getGame()->getId()]);
                } catch (InvalidPlayerAddedException $err) {
                    $this->addFlash('warning', $err->getMessage());
                }
            }
        } else {
            $num_cards = $this->container->getParameter('app.game.num_cards');
            $playerNames = [];
        }

        return $this->render('start.html.twig', ['num_cards' => $num_cards, 'name' => $playerNames]);
    }

    /**
     * @param Request $request
     * @param int $gameId
     * @return Response
     * @Route("/play/{gameId}", name="play", requirements={"gameId": "\d+"})
     */
    public function playAction(Request $request, $gameId)
    {
        $gameService = $this->get('app.game_service');
        $game = $gameService->findGameById($gameId);

        if (!$game->isActive()) {
            return $this->redirectToRoute('results', ['gameId' => $gameId]);
        }

        $table = $gameService->loadGameTable($game);

        $bets = $request->request->get('bet', []);

        if ($request->isMethod('POST')) {
            try {
                $table->placeBets($bets);
                $table->endGame();
                $table->save();

                return $this->redirectToRoute('results', ['gameId' => $gameId]);
            } catch (InvalidBetPlacedException $err) {
                $this->addFlash('warning', $err->getMessage());
            }
        }

        return $this->render('play.html.twig', [
            'game' => $table->getGame(),
            'hands' => $table->getGame()->getPlayerHands(),
            'bets' => $bets
        ]);
    }

    /**
     * @param int $gameId
     * @return Response
     * @Route("/results/{gameId}", name="results", requirements={"gameId": "\d+"})
     */
    public function resultsAction($gameId)
    {
        $gameService = $this->get('app.game_service');
        $game = $gameService->findGameById($gameId);

        $table = $gameService->loadGameTable($game);

        return $this->render('results.html.twig', [
            'game' => $table->getGame(),
            'hands' => $table->getScoredHands(),
            'winningHand' => $table->getWinningHand(),
            'potSize' => $table->getPotSize()
        ]);
    }

    /**
     * @return Response
     * @Route("/leaderboard", name="leaderboard")
     */
    public function leaderboardAction()
    {
        $leaderboard = $this->get('app.leaderboard');

        $mostCoins = $leaderboard->getPlayersWithMostCoins();
        $mostWins = $leaderboard->getPlayersWithMostWins();
        $bestWinningHands = $leaderboard->getBestWinningHands();

        return $this->render(
            'leaderboard.html.twig',
            compact('mostCoins', 'mostWins', 'bestWinningHands')
        );
    }

    /**
     * @return Response
     * @Route("/history", name="history")
     */
    public function historyAction()
    {
        $games = $this->get('app.game_service')->getPastGames();

        return $this->render('history.html.twig', ['games' => $games]);
    }

    /**
     * @param $playerId
     * @return Response
     * @Route("/player/{playerId}", name="player", requirements={"playerId": "\d+"})
     */
    public function playerAction($playerId)
    {
        $playerRepository = $this->getDoctrine()
            ->getRepository('AppBundle:Player');
        $player = $playerRepository->find($playerId);

        if (!$player) {
            throw $this->createNotFoundException(
                'No player found for id ' . $playerId
            );
        }

        $games = $this->get('app.game_service')->getPastGamesForPlayer($player);

        return $this->render('player.html.twig', ['player' => $player, 'games' => $games]);
    }
}
