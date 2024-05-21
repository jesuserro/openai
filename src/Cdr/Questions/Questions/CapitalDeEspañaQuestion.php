<?php

namespace Cdr\Questions\Questions;

use Cdr\Questions\AbstractQuestion;

class CapitalDeEspañaQuestion extends AbstractQuestion {
    protected function initializeQuestion(): string {
        return '¿Cuál es la capital de España?';
    }
}
