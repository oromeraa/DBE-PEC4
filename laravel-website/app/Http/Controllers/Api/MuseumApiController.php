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

    public function index($page)
    {
        $museums = Museum::select($this->basicFields)->paginate(5, ['*'], 'page', $page);

        if ($museums->isEmpty() || $page < 1) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        return response()->json($museums);
    }

    public function museum($id)
    {
        $museum = Museum::select($this->allFields)->find($id);

        if (!$museum) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        return response()->json($museum);
    }

    public function museumTopics($id, $page)
    {
        $topic = Topic::find($id);
        if (!$topic) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        $museums = $topic->museums()->select($this->basicFields)->paginate(5, ['*'], 'page', $page);

        if ($museums->isEmpty() || $page < 1) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        return response()->json($museums);
    }
}
