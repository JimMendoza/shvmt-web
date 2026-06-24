<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['catalogos', 'interfaz'] as $esquema) {
            DB::statement("CREATE SCHEMA IF NOT EXISTS {$esquema}");
        }

        Schema::create('catalogos.estados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('sigla', 20);
            $table->string('descripcion')->nullable();
            $table->string('tipo', 50);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('catalogos.sexos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('estado_id')->nullable()->constrained('catalogos.estados');
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
        });

        Schema::create('catalogos.tipos_documento_identidad', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('abreviatura', 20)->nullable();
            $table->unsignedSmallInteger('caracteres_max')->nullable();
            $table->foreignId('estado_id')->nullable()->constrained('catalogos.estados');
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
        });

        Schema::create('catalogos.departamentos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->nullable();
            $table->string('nombre');
            $table->string('ubigeo_dni', 20)->nullable();
            $table->string('ubigeo_inei', 20)->nullable();
            $table->foreignId('estado_id')->nullable()->constrained('catalogos.estados');
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
        });

        Schema::create('catalogos.provincias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departamento_id')->constrained('catalogos.departamentos')->cascadeOnDelete();
            $table->string('codigo', 20)->nullable();
            $table->string('nombre');
            $table->string('ubigeo_dni', 20)->nullable();
            $table->string('ubigeo_inei', 20)->nullable();
            $table->foreignId('estado_id')->nullable()->constrained('catalogos.estados');
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
        });

        Schema::create('catalogos.distritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provincia_id')->constrained('catalogos.provincias')->cascadeOnDelete();
            $table->string('codigo', 20)->nullable();
            $table->string('nombre');
            $table->string('capital')->nullable();
            $table->string('ubigeo_dni', 20)->nullable();
            $table->string('ubigeo_inei', 20)->nullable();
            $table->foreignId('estado_id')->nullable()->constrained('catalogos.estados');
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
        });

        Schema::create('seguridad.personas', function (Blueprint $table) {
            $table->id();
            $table->string('foto_path')->nullable();
            $table->string('nombres', 120);
            $table->string('apellido_paterno', 120);
            $table->string('apellido_materno', 120)->nullable();
            $table->foreignId('tipo_documento_id')->nullable()->constrained('catalogos.tipos_documento_identidad');
            $table->string('numero_documento', 30)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->foreignId('sexo_id')->nullable()->constrained('catalogos.sexos');
            $table->string('direccion', 400)->nullable();
            $table->string('correo')->nullable();
            $table->string('telefono_movil', 30)->nullable();
            $table->foreignId('distrito_id')->nullable()->constrained('catalogos.distritos');
            $table->string('referencia', 400)->nullable();
            $table->foreignId('estado_id')->nullable()->constrained('catalogos.estados');
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
        });

        Schema::table('seguridad.usuarios', function (Blueprint $table) {
            $table->foreignId('persona_id')->nullable()->after('id')->constrained('seguridad.personas')->nullOnDelete();
            $table->string('username')->nullable()->unique()->after('persona_id');
        });

        Schema::create('interfaz.menus', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('icono')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->foreignId('estado_id')->nullable()->constrained('catalogos.estados');
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
        });

        Schema::create('interfaz.menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('interfaz.menus')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('interfaz.menu_items')->cascadeOnDelete();
            $table->string('tipo', 30)->default('LINK');
            $table->string('titulo');
            $table->string('icono')->nullable();
            $table->string('ruta')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->string('permiso_codigo')->nullable();
            $table->foreignId('estado_id')->nullable()->constrained('catalogos.estados');
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('seguridad.usuarios')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interfaz.menu_items');
        Schema::dropIfExists('interfaz.menus');

        Schema::table('seguridad.usuarios', function (Blueprint $table) {
            $table->dropConstrainedForeignId('persona_id');
            $table->dropColumn('username');
        });

        Schema::dropIfExists('seguridad.personas');
        Schema::dropIfExists('catalogos.distritos');
        Schema::dropIfExists('catalogos.provincias');
        Schema::dropIfExists('catalogos.departamentos');
        Schema::dropIfExists('catalogos.tipos_documento_identidad');
        Schema::dropIfExists('catalogos.sexos');
        Schema::dropIfExists('catalogos.estados');
    }
};
