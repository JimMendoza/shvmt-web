<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['sistema', 'seguridad', 'catalogos', 'interfaz', 'contenido', 'programa', 'galeria', 'multimedia'] as $esquema) {
            DB::statement("CREATE SCHEMA IF NOT EXISTS {$esquema}");
        }
    }

    public function down(): void
    {
        foreach (['multimedia', 'galeria', 'programa', 'contenido', 'interfaz', 'catalogos', 'seguridad', 'sistema'] as $esquema) {
            DB::statement("DROP SCHEMA IF EXISTS {$esquema}");
        }
    }
};
