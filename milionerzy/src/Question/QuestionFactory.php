<?php

namespace Sda\Millionaires\Question;

use Sda\Millionaires\Importer\Exception\ImporterException;
use Sda\Millionaires\Importer\Importer;

/**
 * Class QuestionFactory
 * @package Sda\Millionaires\Question
 */
class QuestionFactory
{
    /**
     * @param $actualPrize
     * @param $actualQuestion
     * @return Question
     * @throws ImporterException
     */
    public static function buildQuestion($actualPrize, $actualQuestion)
    {
        $importer = new Importer();
        $actualQuestionArray = $importer->jsonImport($actualPrize, $actualQuestion);


        $answers = [];
        foreach ($actualQuestionArray['answers'] as $answer) {
            $answers[] = new Answer($answer['id'], $answer['answer'], (bool)$answer['correct']);
        }

        //shuffle($answers);

        return new Question($actualQuestionArray['id'], $actualQuestionArray['question'], $answers);
    }
}
