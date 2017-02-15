<?php

namespace Sda\Millionaires\Controller;

use Sda\Millionaires\Config\Config;
use Sda\Millionaires\Config\Routing;
use Sda\Millionaires\Db\DbConnection;
use Sda\Millionaires\Importer\Exception\ImporterException;
use Sda\Millionaires\Prize\PrizeCollection;
use Sda\Millionaires\Prize\PrizeRepository;
use Sda\Millionaires\Question\Exception\QuestionException;
use Sda\Millionaires\Question\QuestionFactory;
use Sda\Millionaires\Request\Request;
use Sda\Millionaires\Session\Session;
use Sda\Millionaires\Wheel\Exception\WheelException;
use Sda\Millionaires\Wheel\WheelFactory;
use Twig_Environment;
use Twig_Error_Loader;
use Twig_Error_Runtime;
use Twig_Error_Syntax;

/**
 * Class Millionaires
 * @package Sda\Millionaires\Controller
 */
class Millionaires
{

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Twig_Environment
     */
    private $templates;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var string
     */
    private $username;
    /**
     * @var PrizeCollection
     */
    private $prizes;
    private $actualPrize;
    private $actualQuestion;
    /**
     * @var array
     */
    private $usedWheels;
    /**
     * @var DbConnection
     */
    private $dbConnection;

    /**
     * Millionaires constructor.
     * @param Twig_Environment $templates
     * @param Request $request
     * @param Session $session
     * @param DbConnection $dbConnection
     */
    public function __construct(
        Twig_Environment $templates,
        Request $request,
        Session $session,
        DbConnection $dbConnection
    ) {
        $this->templates = $templates;
        $this->request = $request;
        $this->session = $session;
        $this->dbConnection = $dbConnection;

        $this->username = $this->session->get('username', '');
        $this->actualPrize = $this->session->get('actualPrize', Config::PRIZE1);
        $this->actualQuestion = $this->session->get('actualQuestion', -1);
        $this->usedWheels = $this->session->get('usedWheels', []);

        $this->prizes = (new PrizeRepository($dbConnection))->getAllPrizes($this->actualPrize);
    }

    public function run()
    {

        $action = $this->request->getParamFormGet('action', Routing::LOGIN);

        switch ($action) {
            case Routing::LOGIN:
                $this->loginAction();
                break;
            case Routing::LOGOUT:
                $this->logoutAction();
                break;
            case Routing::RULES:
                $this->rulesAction();
                break;
            case Routing::GAME:
                $this->gameAction();
                break;
            case Routing::AJAX_PRIZES:
                $this->ajaxPrizes();
                break;
            case Routing::NEXT_LEVEL:
                $this->nextLevelAction();
                break;
            case Routing::USE_WHEEL:
                $this->useWheelAction();
                break;
            case Routing::ERROR_500:
                $this->error500Action();
                break;
            case Routing::ERROR_404:
            default:
                $this->error404Action();
                break;
        }
    }

    private function ajaxPrizes(){
        $this->showJson($this->prizes);
    }

    private function showJson($result){
        echo json_encode($result);
        exit();
    }

    private function useWheelAction()
    {
        $this->checkAccess();

        $params = $this->generateParams();

        $question = QuestionFactory::buildQuestion($this->actualPrize, $this->actualQuestion);
        $params['final_question'] = $question;

        try {
            $wheel = WheelFactory::makeWheel(
                $this->request->getParamFormGet('wheel', ''),
                $this->usedWheels
            );

            $wheel->useWheel($question);
            $this->usedWheels[] = $wheel->getType();
        } catch (WheelException $e) {
            $this->redirect(Routing::ERROR_404);
        }

        //$this->session->put('usedWheels', $this->usedWheels);

        $params['usedWheels'] = $this->usedWheels;

        $this->renderTemplate('game.tmpl.html', $params);
    }

    private function nextLevelAction()
    {

        $this->checkAccess();
        $this->session->put('actualQuestion', -1);
        $this->session->put('actualPrize', $this->getNextPrize());

        $this->redirect(Routing::GAME);
    }

    private function getNextPrize()
    {
        $index = array_search($this->actualPrize, Config::$availablePrizes) + 1;

        if (count(Config::$availablePrizes) <= $index) {
            die ('WYGRAŁES 1000000');
        }

        return Config::$availablePrizes[$index];
    }

    /**
     * @return array
     */
    private function generateParams()
    {
        $params = [];
        $params['answer_symbol'] = Config::$answersSymbol;
        $params['username'] = $this->username;
        $params['prizes'] = $this->prizes;

        return $params;
    }

    private function gameAction()
    {

        $this->checkAccess();
        $answerId = (int)$this->request->getParamFormGet('answerId', 0);

        $params = $this->generateParams();
        try {
            $question = QuestionFactory::buildQuestion($this->actualPrize, $this->actualQuestion);

            $this->actualQuestion = $question->getId();

            if ($answerId > 0) {

                $question->setUserAnswer($answerId);

                if (true === $question->isUserAnswerCorrect()) {
                    $params['winPrize'] = $this->actualPrize;
                } else {
                    $params['winPrize'] = $this->getGuaranteePrize();
                    $this->session->kill();
                }
            }

            $params['final_question'] = $question;
        } catch (QuestionException $e) {
            $this->redirect(Routing::ERROR_404);
        } catch (ImporterException $e) {
            $this->redirect(Routing::ERROR_404);
        }

        $this->session->put('actualQuestion', $this->actualQuestion);
        $this->session->put('actualPrize', $this->actualPrize);

        $this->renderTemplate('game.tmpl.html', $params);
    }

    private function getGuaranteePrize()
    {
        $result = 0;
        foreach (Config::$guarantees as $guarantee) {
            if ($guarantee < $this->actualPrize) {
                $result = $guarantee;
            }
        }

        return $result;
    }

    private function loginAction()
    {
        $params = [];

        $this->username = $this->request->getParamsFormPost('username', $this->username);

        if ('' !== $this->username) {
            $this->session->put('username', $this->username);
            $this->redirect(Routing::RULES);
        } else {
            $this->renderTemplate('login.tmpl.html', $params);
        }
    }

    private function redirect($routing)
    {
        header('Location: ?action=' . $routing);
        exit();
    }

    private function logoutAction()
    {
        $this->session->kill();
        $this->redirect(Routing::LOGIN);
    }

    /**
     * @param $template
     * @param array $params
     */
    private function renderTemplate($template, array $params)
    {
        try {
            echo $this->templates->render($template, $params);
        } catch (Twig_Error_Loader $e) {
            echo $e->getMessage();
        } catch (Twig_Error_Syntax $e) {
            echo $e->getMessage();
        } catch (Twig_Error_Runtime $e) {
            echo $e->getMessage();
        }
    }

    private function rulesAction()
    {
        $this->checkAccess();
        $params = [
            'username' => $this->username
        ];

        $this->renderTemplate('rules.tmpl.html', $params);
    }

    private function checkAccess()
    {
        if ('' === $this->username) {
            $this->redirect(Routing::LOGIN);
        }
    }

    private function error500Action()
    {
        $this->renderTemplate('error_500.tmpl.html', []);
    }

    private function error404Action()
    {
        $this->renderTemplate('error_404.tmpl.html', []);
    }

}
