<?php 

namespace Sda\Millionaires\Question;

class Answer{
    /**
     * @var string
     */
    private $answer;
    /**
     * @var bool
     */
    private $isCorrect;
    /**
     * @var bool
     */
    private $isSelected = false;
    /**
     * @var int
     */
    private $id;
    /**
     * @var bool
     */
    private $isActive = true;

    /**
     * Answer constructor.
     * @param int $id
     * @param string $answer
     * @param bool $isCorrect
     */
    public function __construct($id, $answer, $isCorrect) {
        $this->answer = $answer;
        $this->isCorrect = $isCorrect;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return boolean
     */
    public function isCorrect()
    {
        return $this->isCorrect;
    }

    /**
     * @return boolean
     */
    public function isSelected()
    {
        return $this->isSelected;
    }

    public function setSelected()
    {
        $this->isSelected = true;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->isActive;
    }

    public function setInactive()
    {
        $this->isActive = false;
    }

}



