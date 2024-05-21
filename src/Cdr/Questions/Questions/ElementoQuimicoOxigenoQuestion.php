<?php

namespace Cdr\Questions\Questions;

use Cdr\Questions\AbstractQuestion;

class ElementoQuimicoOxigenoQuestion extends AbstractQuestion {
    protected function initializeQuestion(): string {
        return '¿Cuál es el elemento químico con símbolo O?';
    }
}
