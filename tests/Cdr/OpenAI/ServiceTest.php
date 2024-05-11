<?php

use Cdr\OpenAI\Service as OpenAIService;
use Cdr\OpenAI\ClientWrapper;
use PHPUnit\Framework\TestCase;

class OpenAIServiceTest extends TestCase {
    public function setUpOpenAIService(): OpenAIService {
        $apiKey = getenv('OPENAI_API_KEY');
        if (!$apiKey) {
            $this->fail('API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.');
        }
        $client = new ClientWrapper($apiKey);
        return new OpenAIService($client);
    }

    public function testSayCapitalDeEspaña() {
        $openAIService = $this->setUpOpenAIService();
        
        $response = $openAIService->sayCapitalDeEspaña(); // La capital de España es Madrid.
        
        $this->assertStringContainsString('Madrid', $response, 'La respuesta debería contener \'Madrid\'.');
        
    }

    public function testSayElementoQuimicoLetraO() {
        $openAIService = $this->setUpOpenAIService();
        
        $response = $openAIService->sayElementoQuimicoOxigeno(); // El elemento químico 'O' es el Oxígeno.
        
        $this->assertStringContainsString('Oxígeno', $response, 'La respuesta debería contener \'Oxígeno\'.');
        
    }

    public function testSayPlanetaMasGrandeDelSistemaSolar() {
        $openAIService = $this->setUpOpenAIService();
        
        $response = $openAIService->sayPlanetaMasGrandeDelSistemaSolar(); // Júpiter.
        
        $this->assertStringContainsString('Júpiter', $response, 'La respuesta debería contener \'Júpiter\'.');
        
    }

    public function testSayColorDelCieloEnLaTierra() {
        $openAIService = $this->setUpOpenAIService();
        
        $response = $openAIService->sayColorDelCieloEnLaTierra(); // El cielo en el planeta Tierra es generalmente de color azul durante un día despejado. Sin embargo, puede variar en otras condiciones, como al amanecer o al atardecer cuando puede aparecer en tonos de rojo, naranja, rosa o púrpura.
        
        $this->assertStringContainsString('azul', $response, 'La respuesta debería contener \'azul\'.');
        
    }

    public function testSayPaymentMethodsInCentraldereservas() {
        $openAIService = $this->setUpOpenAIService();
        
        $response = $openAIService->sayPaymentMethodsInCentraldereservas(); 
        /*
        En Centraldereservas.com se pueden realizar pagos utilizando diferentes métodos:

            1. Tarjeta de crédito: es el método más común e inmediato. Aceptan la mayoría de las tarjetas como Visa, MasterCard, AMEX, etc.
            
            2. Transferencia bancaria: puedes transferir el monto del pago a su cuenta bancaria. Sin embargo, debes tener en cuenta que la reserva no se confirma hasta que reciben el pago, lo que puede tardar unos días.
            
            3. PayPal: si tienes una cuenta de PayPal, puedes utilizarla para realizar tus pagos.
            
            4. Pago a plazos: algunos establecimientos permiten el pago a plazos.
            
            5. Pago en el hotel: para algunas reservas, Centraldereservas.com ofrece la opción de pagar directamente en el hotel al llegar.
            
            Recuerda que los métodos de pago pueden variar en función al país y al hotel. Antes de realizar una reserva, asegúrate de comprobar los métodos de pago disponibles.
            */
        
        $this->assertStringContainsString('Transferencia', $response, 'La respuesta debería contener \'Transferencia\'.');
        $this->assertStringContainsString('PayPal', $response, 'La respuesta debería contener \'PayPal\'.');
        // $this->assertStringContainsString('efectivo', $response, 'La respuesta debería contener \'efectivo\'.');

        // If pass the test, save the response in database
        // $this->saveResponseInDatabase($response);
        
    }

    public function createPDF() {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,'La capital de España es Madrid.');
        $pdf->Output();
    }

    public function saveResponseInDatabase(string $response) {
        $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
        $stmt = $pdo->prepare('INSERT INTO responses (response) VALUES (:response)');
        $stmt->execute(['response' => $response]);
    }
    
}
