<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Museum;
use App\Models\Topic;

class MuseumApiController extends Controller
{
    public function catalog($page)
    {
        $museums = Museum::paginate(5, ['*'], 'page', $page);

        if ($museums->isEmpty() || $page < 1) {
            return response()->json(['error' => 'Page Not Found'], 404);
        }

        return response()->json($museums);
    }

    public function museum($id)
    {
        $museum = Museum::with('topics')->findOrFail($id);
        return response()->json($museum);
    }

    public function museumTopics($id, $page)
    {
        $topic = Topic::find($id);
        if (!$topic) return response()->json(['error' => 'Topic Not Found'], 404);

        $museums = $topic->museums()
            ->select('museums.id', 'museums.nombre', 'museums.ciudad', 'museums.precio', 'museums.fechas_horarios', 'museums.visitas_guiadas', 'museums.imagen_portada')
            ->paginate(5, ['*'], 'page', $page);

        if ($museums->isEmpty()) {
            return response()->json(['error' => 'Page Not Found'], 404);
        }

        return response()->json($museums);
    }
}
