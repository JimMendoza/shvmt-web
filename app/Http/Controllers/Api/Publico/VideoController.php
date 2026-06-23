<?php

namespace App\Http\Controllers\Api\Publico;

use App\Http\Controllers\Controller;
use App\Models\Multimedia\Video;

class VideoController extends Controller
{
    public function index()
    {
        return Video::query()
            ->where('publicado', true)
            ->orderByDesc('destacado')
            ->orderByDesc('anio')
            ->orderBy('orden')
            ->get();
    }

    public function show(string $slug)
    {
        return Video::query()
            ->where('publicado', true)
            ->where('slug', $slug)
            ->firstOrFail();
    }
}
