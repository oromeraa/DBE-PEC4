<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Museum;
use App\Models\Topic;

class MuseumApiController extends Controller
{

    protected $allFields = ['id', 'nombre', 'ciudad', 'fechas_horarios', 'visitas_guiadas', 'precio', 'imagen_portada'];
    protected $basicFields = ['museums.id', 'museums.nombre', 'museums.ciudad'];

    public function catalog($page)
    {
        $museums = Museum::select($this->allFields)->paginate(5, ['*'], 'page', $page);

        if ($museums->isEmpty() || $page < 1) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        return response()->json($museums->getCollection());
    }

    public function museum($id)
    {
        $museum = Museum::select($this->allFields)->find($id);

        if (!$museum) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        return response()->json($museum);
    }

    public function byTopics($id, $page)
    {
        $topic = Topic::find($id);
        if (!$topic) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        $museumIds = $topic->museums()->pluck('museums.id');
        
        $museums = Museum::select($this->basicFields)
            ->whereIn('id', $museumIds)
            ->paginate(5, ['*'], 'page', $page);

        if ($museums->isEmpty() || $page < 1) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        return response()->json($museums->getCollection());
    }
}
