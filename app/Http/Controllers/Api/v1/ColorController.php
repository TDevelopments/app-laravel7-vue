<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Color;
use App\Http\Requests\ColorRequest;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Models\History;
use Carbon\Carbon;

class ColorController extends Controller
{
    protected $color;

    public function __construct(Color $color)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:listar colores', ['only' => ['index']]);
        $this->middleware('permission:crear color', ['only' => ['store']]);
        $this->middleware('permission:mostrar color', ['only' => ['show']]);
        $this->middleware('permission:editar color', ['only' => ['update']]);
        $this->middleware('permission:eliminar color', ['only' => ['destroy']]);
        $this->color = $color;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = $this->color->select('id', 'name', 'code')->get();
        return response([
            'data' => $colors
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ColorRequest $request)
    {
        $color = $this->color->create($request->toArray());
        History::create([
            'action' => 'Creando color',
            'model_type' => 'App\Models\Color',
            'model_id' => $color->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response()->json($color, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Color $color)
    {
        return response()->json($color, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ColorRequest $request,Color $color)
    {
        History::create([
            'action' => 'Actualizando color',
            'model_type' => 'App\Models\Color',
            'model_id' => $color->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $color->update($request->toArray());
        return response()->json($color, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Color $color, Request $request)
    {
        History::create([
            'action' => 'Eliminando Color',
            'model_type' => 'App\Models\Color',
            'model_id' => $color->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $color->delete();
        return response()->json(null, 204);
    }
}
