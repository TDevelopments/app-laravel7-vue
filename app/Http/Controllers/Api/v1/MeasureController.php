<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Measure;
use Illuminate\Http\Request;
use App\Http\Requests\MeasureRequest;
use App\Http\Controllers\Controller;
use App\Models\History;
use Carbon\Carbon;

class MeasureController extends Controller
{
    protected $measure;

    public function __construct(Measure $measure)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Importaciones - listar unidades', ['only' => ['index']]);
        $this->middleware('permission:Importaciones - crear unidad', ['only' => ['store']]);
        $this->middleware('permission:Importaciones - mostrar unidad', ['only' => ['show']]);
        $this->middleware('permission:Importaciones - editar unidad', ['only' => ['update']]);
        $this->middleware('permission:Importaciones - eliminar unidad', ['only' => ['destroy']]);
        $this->measure = $measure;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->measure->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeasureRequest $request)
    {
        $measure = $this->measure->create($request->toArray());
        History::create([
            'action' => 'Creando unidad producto',
            'model_type' => 'App\Models\Measure',
            'model_id' => $measure->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response()->json($measure, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Measure  $measure
     * @return \Illuminate\Http\Response
     */
    public function show(Measure $measure)
    {
        return response()->json($measure, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Measure  $measure
     * @return \Illuminate\Http\Response
     */
    public function update(MeasureRequest $request, Measure $measure)
    {
        History::create([
            'action' => 'Actualizando unidad producto',
            'model_type' => 'App\Models\Measure',
            'model_id' => $measure->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $measure->update($request->toArray());
        return response()->json($measure, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Measure  $measure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Measure $measure, Request $request)
    {
        History::create([
            'action' => 'Elimnando unidad producto',
            'model_type' => 'App\Models\Measure',
            'model_id' => $measure->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $measure->delete();
        return response()->json(null, 204);
    }
}
