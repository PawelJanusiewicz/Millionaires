<?php

namespace Sda\Millionaires\Wheel;

use Sda\Millionaires\Question\Question;

class FiftyFifty implements WheelSwitch
{

    /**
     * @var string
     */
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isUsed()
    {
        // TODO: Implement isUsed() method.
    }


    /**
     * @param Question $question
     * @return Question
     */
    public function useWheel(Question $question)
    {
        $incorrectAnswers = $question->getIncorrectAnswers();

        $index = mt_rand(0, count($incorrectAnswers));
        unset($incorrectAnswers[$index]);

        foreach ($incorrectAnswers as $incorrectAnswer) {
            $question->setAnswerToInactive($incorrectAnswer);
        }

        return $question;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}