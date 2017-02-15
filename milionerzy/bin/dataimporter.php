<?php

use Doctrine\DBAL\Driver\Connection;
use Sda\Millionaires\Config\Config;
use Sda\Millionaires\Db\DbConnection;

require_once(__DIR__ . '/../vendor/autoload.php');

$db = new DbConnection(
    Config::$connectionParams
);

$dir = __DIR__ . '/../data/';

$scannedDirectory = array_diff(scandir($dir), array('..', '.'));

$connection = $db->getConnection();

foreach (Config::$availablePrizes as $prize) {

    $isGuarantee = (in_array($prize, Config::$guarantees)) ? 'true' : 'false';

    $query = $connection->createQueryBuilder();

    $query
        ->insert('prizes')
        ->setValue('value', '?')
        ->setValue('guarantee', '?')
        ->setParameter(0, $prize)
        ->setParameter(1, $isGuarantee)
        ->execute();

    $prizeId = $connection->lastInsertId();

    addQuestion($prizeId, $prize, $scannedDirectory, $connection);
}


function addQuestion($prizeId, $prize, $scannedDirectory, Connection $connection)
{
    foreach ($scannedDirectory as $file) {
        if ($file !== 'questions_' . $prize . '.json') {
            continue;
        }

        $jsonStr = file_get_contents(__DIR__ . '/../data/' . $file);
        $data = json_decode($jsonStr, true);

        foreach ($data['questions'] as $question) {
            $query = $connection->createQueryBuilder();

            $query
                ->insert('questions')
                ->setValue('prizes_id', '?')
                ->setValue('question', '?')
                ->setParameter(0, $prizeId)
                ->setParameter(1, $question['question'])
                ->execute()
            ;

            $questionId = $connection->lastInsertId();

            addAnswers($questionId, $question['answers'], $connection);
        }
    }
}

function addAnswers($questionId, array $answers, Connection $connection)
{
    foreach ($answers as $answer) {

        $isCorrect = $answer['correct'] ? 'true' : 'false';

        $query = $connection->createQueryBuilder();

        $query
            ->insert('answers')
            ->setValue('questions_id', '?')
            ->setValue('answer', '?')
            ->setValue('correct', '?')
            ->setParameter(0, $questionId)
            ->setParameter(1, $answer['answer'])
            ->setParameter(2, $isCorrect)
            ->execute()
        ;
    }
}