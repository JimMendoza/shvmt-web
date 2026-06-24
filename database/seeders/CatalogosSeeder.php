<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogosSeeder extends Seeder
{
    public function run(): void
    {
        $data = json_decode(file_get_contents(database_path('seeders/data/catalogos_sgep.json')), true);

        foreach ([
            'catalogos.estados' => $data['estados'],
            'catalogos.sexos' => $data['sexos'],
            'catalogos.tipos_documento_identidad' => $data['tipos_documento_identidad'],
            'catalogos.departamentos' => $data['departamentos'],
            'catalogos.provincias' => $data['provincias'],
            'catalogos.distritos' => $data['distritos'],
        ] as $tabla => $filas) {
            DB::table($tabla)->upsert(
                array_map(fn (array $fila) => $this->limpiarFila($fila), $filas),
                ['id'],
            );
        }

        foreach ([
            ['catalogos.estados', 'catalogos.estados_id_seq'],
            ['catalogos.sexos', 'catalogos.sexos_id_seq'],
            ['catalogos.tipos_documento_identidad', 'catalogos.tipos_documento_identidad_id_seq'],
            ['catalogos.departamentos', 'catalogos.departamentos_id_seq'],
            ['catalogos.provincias', 'catalogos.provincias_id_seq'],
            ['catalogos.distritos', 'catalogos.distritos_id_seq'],
        ] as [$tabla, $secuencia]) {
            DB::statement("SELECT setval('{$secuencia}', COALESCE((SELECT MAX(id) FROM {$tabla}), 1))");
        }
    }

    private function limpiarFila(array $fila): array
    {
        return collect($fila)
            ->except(['created_by', 'updated_by'])
            ->map(fn ($valor) => $valor === '' ? null : $valor)
            ->all();
    }
}
