<?php

namespace Sda\Millionaires\Wheel;

use Sda\Millionaires\Question\Question;

class ExpertQuestion implements WheelSwitch
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