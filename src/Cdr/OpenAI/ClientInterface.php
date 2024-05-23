<?php

namespace Cdr\OpenAI;

interface ClientInterface {
    public function chat();

    // Nueva función para recuperar un asistente por su ID
    public function retrieve(string $assistantId): array;
}
