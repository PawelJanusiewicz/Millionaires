<?php

namespace Sda\Millionaires\Config;

class Config
{
    const DEBUG = true;

    const ABSOLUTE_TEMPLATE_DIR = __DIR__ . '/../View/';
    const ABSOLUTE_CACHE_TEMPLATE_DIR = __DIR__ . '/../../cache';


    public static $connectionParams = array(
        'dbname' => 'milionerzy',
        'user' => 'root',
        'password' => '',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
        'charset' => 'utf8'
    );


    const PRIZE1 = '100';
    const PRIZE2 = '200';
    const PRIZE3 = '300';
    const PRIZE4 = '500';
    const PRIZE5 = '1000';
    const PRIZE6 = '2000';
    const PRIZE7 = '4000';
    const PRIZE8 = '8000';
    const PRIZE9 = '16000';
    const PRIZE10 = '32000';
    const PRIZE11 = '64000';
    const PRIZE12 = '125000';
    const PRIZE13 = '250000';
    const PRIZE14 = '500000';
    const PRIZE15 = '1000000';

    const A = 'A';
    const B = 'B';
    const C = 'C';
    const D = 'D';

    static public $guarantees = [
        self::PRIZE5,
        self::PRIZE10
    ];

    static public $availablePrizes = [
        self::PRIZE1,
        self::PRIZE2,
        self::PRIZE3,
        self::PRIZE4,
        self::PRIZE5,
        self::PRIZE6,
        self::PRIZE7,
        self::PRIZE8,
        self::PRIZE9,
        self::PRIZE10,
        self::PRIZE11,
        self::PRIZE12,
        self::PRIZE13,
        self::PRIZE14,
        self::PRIZE15
    ];

    static public $answersSymbol = [
        self::A,
        self::B,
        self::C,
        self::D
    ];

    //Ścieżka do pliku json
    const ABSOLUTE_PATH_TO_JSON = __DIR__ . '/../../data/questions_';
    const ABSOLUTE_JSON_EXTEND = '.json';
}