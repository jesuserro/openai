<?php

namespace Cdr;

class Tarea
{
    /**
     * Busca tareas
     *
     * @param array $datos
     * @param int|null $start
     * @param int|null $limit
     * @return array
     */
    public function listaTareas(array $datos, ?int $start = null, ?int $limit = null): array
    {
        $tareas = [
            [
                'id' => 1,
                'nombre' => 'Tarea 1',
                'descripcion' => 'Descripción de la tarea 1',
                'prioridad' => 'Alta'
            ],
            [
                'id' => 2,
                'nombre' => 'Tarea 2',
                'descripcion' => 'Descripción de la tarea 2',
                'prioridad' => 'Media'
            ],
            [
                'id' => 3,
                'nombre' => 'Tarea 3',
                'descripcion' => 'Descripción de la tarea 3',
                'prioridad' => 'Baja'
            ]
        ];

        return [
            'result' => [
                'success' => true,
                'data' => array_slice($tareas, $start ?? 0, $limit ?? count($tareas)),
                'total' => count($tareas),
                'totalesPorPrioridad' => [
                    'Alta' => 1,
                    'Media' => 1,
                    'Baja' => 1
                ],
                'totalEntradaInminente' => 0
            ]
        ];
    }
}
