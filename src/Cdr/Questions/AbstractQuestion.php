<?php

namespace Cdr\Questions;

abstract class AbstractQuestion implements QuestionInterface {
    protected string $question;

    public function __construct() {
        $this->question = $this->initializeQuestion();
    }

    abstract protected function initializeQuestion(): string;

    public function getQuestion(): string {
        return $this->question;
    }
}
