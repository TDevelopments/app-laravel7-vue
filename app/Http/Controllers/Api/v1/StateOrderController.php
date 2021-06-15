<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\StateOrder;
use Illuminate\Http\Request;
use App\Http\Requests\StateOrderRequest;
use App\Http\Controllers\Controller;

class StateOrderController extends Controller
{
    protected $stateOrder;

    public function __construct(StateOrder $stateOrder)
    {
        $this->middleware('api.admin');
        $this->middleware('permission:Importaciones - listar estados de orden', ['only' => ['index']]);
        $this->middleware('permission:Importaciones - crear estado de orden', ['only' => ['store']]);
        $this->middleware('permission:Importaciones - mostrar estado de orden', ['only' => ['show']]);
        $this->middleware('permission:Importaciones - editar estado de orden', ['only' => ['update']]);
        $this->middleware('permission:Importaciones - eliminar estado de orden', ['only' => ['destroy']]);
        $this->stateOrder = $stateOrder;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->stateOrder->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateOrderRequest $request)
    {
        $stateOrder = $this->stateOrder->create($request->toArray());
        return response()->json($stateOrder, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Measure  $stateOrder
     * @return \Illuminate\Http\Response
     */
    public function show(StateOrder $stateOrder)
    {
        return response()->json($stateOrder, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Measure  $stateOrder
     * @return \Illuminate\Http\Response
     */
    public function update(StateOrderRequest $request, StateOrder $stateOrder)
    {
        $stateOrder->update($request->toArray());
        return response()->json($stateOrder, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\stateOrder  $stateOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(StateOrder $stateOrder)
    {
        $stateOrder->delete();
        return response()->json(null, 204);
    }
}
