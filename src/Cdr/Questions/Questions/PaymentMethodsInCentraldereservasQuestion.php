<?php

namespace Cdr\Questions\Questions;

use Cdr\Questions\AbstractQuestion;

class PaymentMethodsInCentraldereservasQuestion extends AbstractQuestion {
    protected function initializeQuestion(): string {
        return '¿Cuáles son los métodos de pago en Centraldereservas.com?';
    }
}