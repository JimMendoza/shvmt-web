<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contenido.configuraciones_sitio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_sitio');
            $table->string('subtitulo_sitio')->nullable();
            $table->unsignedSmallInteger('anio_principal')->nullable();
            $table->date('fecha_principal')->nullable();
            $table->string('titulo_portada')->nullable();
            $table->text('subtitulo_portada')->nullable();
            $table->string('imagen_portada')->nullable();
            $table->string('video_portada')->nullable();
            $table->string('logo')->nullable();
            $table->string('color_primario', 20)->nullable();
            $table->string('color_secundario', 20)->nullable();
            $table->string('telefono_contacto')->nullable();
            $table->string('correo_contacto')->nullable();
            $table->string('url_facebook')->nullable();
            $table->string('url_youtube')->nullable();
            $table->string('url_tiktok')->nullable();
            $table->string('url_instagram')->nullable();
            $table->timestamps();
        });

        Schema::create('contenido.secciones_historia', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('subtitulo')->nullable();
            $table->text('contenido')->nullable();
            $table->string('imagen')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('publicado')->default(false);
            $table->timestamps();
        });

        Schema::create('contenido.mayordomias', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('anio');
            $table->string('titulo');
            $table->string('nombre_familia')->nullable();
            $table->string('nombre_mayordoma_principal')->nullable();
            $table->text('mensaje')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('actual')->default(false);
            $table->boolean('publicado')->default(false);
            $table->timestamps();
        });

        Schema::create('programa.dias_programa', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->date('fecha');
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('publicado')->default(false);
            $table->timestamps();
        });

        Schema::create('programa.actividades_programa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dia_programa_id')->constrained('programa.dias_programa')->cascadeOnDelete();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->string('nombre_lugar')->nullable();
            $table->string('direccion')->nullable();
            $table->string('url_mapa')->nullable();
            $table->text('url_mapa_incrustado')->nullable();
            $table->string('responsable')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('publicado')->default(false);
            $table->timestamps();
        });

        Schema::create('galeria.albumes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->unsignedSmallInteger('anio')->nullable();
            $table->foreignId('foto_portada_id')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('publicado')->default(false);
            $table->timestamps();
        });

        Schema::create('galeria.fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained('galeria.albumes')->cascadeOnDelete();
            $table->string('titulo')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('ruta_archivo');
            $table->string('ruta_miniatura')->nullable();
            $table->string('ruta_mediana')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('publicado')->default(false);
            $table->timestamps();
        });

        Schema::table('galeria.albumes', function (Blueprint $table) {
            $table->foreign('foto_portada_id')->references('id')->on('galeria.fotos')->nullOnDelete();
        });

        Schema::create('multimedia.videos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->string('url_video');
            $table->text('url_incrustado')->nullable();
            $table->string('miniatura')->nullable();
            $table->string('categoria')->nullable();
            $table->unsignedSmallInteger('anio')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('destacado')->default(false);
            $table->boolean('publicado')->default(false);
            $table->timestamps();
        });

        Schema::create('contenido.comunicados', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('contenido')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('destacado')->default(false);
            $table->boolean('publicado')->default(false);
            $table->timestamp('publicado_en')->nullable();
            $table->timestamps();
        });

        Schema::create('contenido.ubicaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('direccion')->nullable();
            $table->string('url_mapa')->nullable();
            $table->text('url_mapa_incrustado')->nullable();
            $table->string('tipo')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('publicado')->default(false);
            $table->timestamps();
        });

        Schema::create('contenido.colaboradores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('tipo')->nullable();
            $table->string('imagen')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('publicado')->default(false);
            $table->timestamps();
        });

        Schema::create('contenido.entradas_historicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('anio');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->text('mayordomos')->nullable();
            $table->string('imagen_portada')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('publicado')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('galeria.albumes', function (Blueprint $table) {
            $table->dropForeign(['foto_portada_id']);
        });

        Schema::dropIfExists('contenido.entradas_historicas');
        Schema::dropIfExists('contenido.colaboradores');
        Schema::dropIfExists('contenido.ubicaciones');
        Schema::dropIfExists('contenido.comunicados');
        Schema::dropIfExists('multimedia.videos');
        Schema::dropIfExists('galeria.fotos');
        Schema::dropIfExists('galeria.albumes');
        Schema::dropIfExists('programa.actividades_programa');
        Schema::dropIfExists('programa.dias_programa');
        Schema::dropIfExists('contenido.mayordomias');
        Schema::dropIfExists('contenido.secciones_historia');
        Schema::dropIfExists('contenido.configuraciones_sitio');
    }
};
