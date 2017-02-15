<?php

namespace Sda\Millionaires\Wheel;

use Sda\Millionaires\Question\Question;

/**
 * Interface WheelSwitch
 * @package Sda\Millionaires\Wheel
 */
interface WheelSwitch
{
    const WHEEL_FIFTY_FIFTY = 'fiftyfifty';
    const WHEEL_PUBLIC_QUESTION = 'publicQuestion';
    const WHEEL_EXPERT_QUESTION = 'expertQuestion';
    const WHEEL_CHANGE_QUESTION = 'changeQuestion';

    /**
     * @return bool
     */
    public function isUsed();

    /**
     * @return string
     */
    public function getType();

    /**
     * @param Question $question
     * @return Question
     */
    public function useWheel(Question $question);
}