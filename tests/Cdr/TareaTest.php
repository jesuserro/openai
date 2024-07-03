<?php
namespace Tests\Cdr;

use PHPUnit\Framework\TestCase;
use Cdr\Tarea;

class TareaTest extends TestCase {

    public function testObtenerListaTareas()
    {
        $tareaService = new Tarea();
        
        $result = $tareaService->listaTareas([], 0, 3);

        $this->assertTrue($result['result']['success']);
        $this->assertCount(3, $result['result']['data']);
        $this->assertEquals(3, $result['result']['total']);
    }
}
