<?php
namespace Sda\Millionaires\Question;

use Sda\Millionaires\Exception\ExceptionCodes;
use Sda\Millionaires\Exception\ExceptionMessages;
use Sda\Millionaires\Question\Exception\QuestionException;

class Question
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $question;
    /**
     * @var array
     */
    private $answers;
    /**
     * @var Answer
     */
    private $userAnswer;

    /**
     * Question constructor.
     * @param int $id
     * @param string $question
     * @param array $answers
     */
    public function __construct($id, $question, array $answers)
    {
        $this->id = $id;
        $this->question = $question;
        $this->answers = $answers;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @return array
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    public function getIncorrectAnswers(){
        $incorrectAnswers = [];
        /** @var Answer $answer */
        foreach ($this->answers as $answer) {
            if (false == $answer->isCorrect())
            {
                $incorrectAnswers[] = $answer;
            }
        }

        return $incorrectAnswers;
    }

    /**
     * @param int $answerId
     * @throws QuestionException
     */
    public function setUserAnswer($answerId)
    {
        /** @var Answer $answer */
        foreach ($this->answers as $answer) {
            if ($answer->getId() === $answerId)
            {
                $answer->setSelected();
                $this->userAnswer = $answer;
                return;
            }
        }
        
        throw new QuestionException(
            ExceptionMessages::ANSWER_NOT_FOUND,
            ExceptionCodes::ANSWER_NOT_FOUND
        );
    }

    public function isAnswer(){
        return (null !== $this->userAnswer);
    }

    /**
     * @return bool
     */
    public function isUserAnswerCorrect()
    {
        return $this->userAnswer->isCorrect();
    }

    public function setAnswerToInactive(Answer $incorrectAnswer)
    {
        /** @var Answer $answer */
        foreach ($this->answers as $answer) {
            if ($answer === $incorrectAnswer)
            {
                $answer->setInactive();
            }
        }
    }
}

