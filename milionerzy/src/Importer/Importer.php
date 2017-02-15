<?php
namespace Sda\Millionaires\Importer;

use Sda\Millionaires\Config\Config;
use Sda\Millionaires\Importer\Exception\ImporterException;
use Sda\Millionaires\Request\Exception\ExceptionCodes;
use Sda\Millionaires\Request\Exception\ExceptionMessages;

/**
 * Class Importer
 * @package Sda\Millionaires\Importer
 */
class Importer
{
    /**
     * @param int $actualPrize
     * @param int $actualQuestion
     * @return array
     * @throws ImporterException
     */
    public function jsonImport($actualPrize, $actualQuestion)
    {
        $json = file_get_contents(Config::ABSOLUTE_PATH_TO_JSON . $actualPrize . Config::ABSOLUTE_JSON_EXTEND);
        $content = json_decode($json, true);
        if ($actualQuestion >= 0){
            return $this->getSpecificQuestion($content['questions'], $actualQuestion);
        } else{
            return $this->getRandomQuestion($content['questions']);
        }

    }

    /**
     * @param array $questions
     * @return int
     */
    private function getRandomQuestion(array $questions)
    {
        $randomNumber = mt_rand(0, count($questions) - 1);
        return $questions[$randomNumber];
    }

    /**
     * @param array $questions
     * @param $actualQuestion
     * @return mixed
     * @throws ImporterException
     */
    private function getSpecificQuestion(array $questions, $actualQuestion)
    {
        foreach ($questions as $question) {
            if ($actualQuestion === $question['id']){
                return $question;
            }
        }
        
        throw new ImporterException(
            ExceptionMessages::QUESTION_NOT_FOUND,
            ExceptionCodes::QUESTION_NOT_FOUND
        );
    }
}

