<?php

use Sda\Millionaires\Config\Config;
use Sda\Millionaires\Controller\Millionaires;
use Sda\Millionaires\Db\DbConnection;
use Sda\Millionaires\Request\Request;
use Sda\Millionaires\Session\Session;

require_once(__DIR__ . '/../vendor/autoload.php');

$twig = new Twig_Environment(
    new Twig_Loader_Filesystem(Config::ABSOLUTE_TEMPLATE_DIR),
    array(
        'cache' => (false === Config::DEBUG) ? Config::ABSOLUTE_CACHE_TEMPLATE_DIR : false
    )
);

$request = new Request();
$session = new Session();

$db = new DbConnection(
    Config::$connectionParams
);

$app = new Millionaires(
    $twig,
    $request,
    $session,
    $db
);

$app->run();