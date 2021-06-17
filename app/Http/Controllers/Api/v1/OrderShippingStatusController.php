<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderShippingStatus;
use App\Http\Requests\OrderShippingStatusRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\History;
use Carbon\Carbon;

class OrderShippingStatusController extends Controller
{
    protected $shippingStatus;

    public function __construct(OrderShippingStatus $shippingStatus)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Importaciones - listar estados de envio', ['only' => ['index']]);
        $this->middleware('permission:Importaciones - crear estado de envio', ['only' => ['store']]);
        $this->middleware('permission:Importaciones - mostrar estado de envio', ['only' => ['show']]);
        $this->middleware('permission:Importaciones - editar estado de envio', ['only' => ['update']]);
        $this->middleware('permission:Importaciones - eliminar estado de envio', ['only' => ['destroy']]);
        $this->shippingStatus = $shippingStatus;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query("list")) {
            $value = $request->query("list");
            $result = $this->shippingStatus->get();
            return response([
                'data' => $result
            ], Response::HTTP_OK);
        }
        return response()->json($this->shippingStatus->paginate(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderShippingStatusRequest $request)
    {
        $shippingStatus = $this->shippingStatus->create($request->toArray());
        History::create([
            'action' => 'Creando estado de envio orden',
            'model_type' => 'App\Models\OrderShippingStatus',
            'model_id' => $shippingStatus->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response()->json($shippingStatus, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OrderShippingStatus $orderShippingStatus)
    {
        return response()->json($orderShippingStatus, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderShippingStatusRequest $request, OrderShippingStatus $orderShippingStatus)
    {
        History::create([
            'action' => 'Actualizando estado de envio orden',
            'model_type' => 'App\Models\OrderShippingStatus',
            'model_id' => $orderShippingStatus->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $orderShippingStatus->update($request->toArray());
        return response()->json($orderShippingStatus, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderShippingStatus $orderShippingStatus, Request $request)
    {
        History::create([
            'action' => 'Eliminando estado de envio orden',
            'model_type' => 'App\Models\OrderShippingStatus',
            'model_id' => $orderShippingStatus->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $orderShippingStatus->delete();
        return response()->json(null, 204);
    }
}
