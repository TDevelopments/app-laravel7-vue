<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\BankEntity;
use Illuminate\Http\Request;
use App\Http\Requests\BankEntityRequest;
use App\Http\Controllers\Controller;
use App\Models\History;
use Carbon\Carbon;

class BankEntityController extends Controller
{
    protected $bank;

    public function __construct(BankEntity $bank)
    {
        /* $this->middleware('api.admin')->except(['index']); */
        $this->middleware('permission:Importaciones - crear entidad bancaria', ['only' => ['store']]);
        $this->middleware('permission:Importaciones - mostrar entidad bancaria', ['only' => ['show']]);
        $this->middleware('permission:Importaciones - editar entidad bancaria', ['only' => ['update']]);
        $this->middleware('permission:Importaciones - eliminar entidad bancaria', ['only' => ['destroy']]);
        $this->bank = $bank;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->bank->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankEntityRequest $request)
    {
        $bank = $this->bank->create($request->toArray());
        History::create([
            'action' => 'Creando entidad bancaria',
            'model_type' => 'App\Models\BankEntity',
            'model_id' => $bank->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response()->json($bank, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(BankEntity $bank)
    {
        return response()->json($bank, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(BankEntityRequest $request, BankEntity $bank)
    {
        $bank->update($request->toArray());
        History::create([
            'action' => 'Actualizando entidad bancaria',
            'model_type' => 'App\Models\BankEntity',
            'model_id' => $bank->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response()->json($bank, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankEntity $bank, Request $request)
    {
        History::create([
            'action' => 'Eliminando entidad bancaria',
            'model_type' => 'App\Models\BankEntity',
            'model_id' => $bank->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $bank->delete();
        return response()->json(null, 204);
    }
}
