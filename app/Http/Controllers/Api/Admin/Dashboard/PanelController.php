<?php

namespace App\Http\Controllers\Api\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PanelController extends Controller
{
    public function resumen(): JsonResponse
    {
        return response()->json([
            'programa' => 0,
            'galeria' => 0,
            'videos' => 0,
            'comunicados' => 0,
        ]);
    }
}
