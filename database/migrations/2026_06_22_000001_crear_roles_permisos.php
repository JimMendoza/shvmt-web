<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seguridad.roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('seguridad.permisos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo')->unique();
            $table->string('modulo');
            $table->timestamps();
        });

        Schema::create('seguridad.rol_usuario', function (Blueprint $table) {
            $table->foreignId('rol_id')->constrained('seguridad.roles')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('seguridad.usuarios')->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['rol_id', 'usuario_id']);
        });

        Schema::create('seguridad.permiso_rol', function (Blueprint $table) {
            $table->foreignId('permiso_id')->constrained('seguridad.permisos')->cascadeOnDelete();
            $table->foreignId('rol_id')->constrained('seguridad.roles')->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['permiso_id', 'rol_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seguridad.permiso_rol');
        Schema::dropIfExists('seguridad.rol_usuario');
        Schema::dropIfExists('seguridad.permisos');
        Schema::dropIfExists('seguridad.roles');
    }
};
