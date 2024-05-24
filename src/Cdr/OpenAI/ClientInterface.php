<?php

namespace Cdr\OpenAI;

interface ClientInterface {
    public function chat();

    public function retrieve(string $assistantId);
}
