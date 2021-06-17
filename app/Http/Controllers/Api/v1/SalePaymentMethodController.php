<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SalePaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalePaymentMethodRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\History;
use Carbon\Carbon;

class SalePaymentMethodController extends Controller
{

    protected $salePaymentMethod;

    public function __construct(SalePaymentMethod $salePaymentMethod)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Ventas - listar metodos de pago', ['only' => ['index']]);
        $this->middleware('permission:Ventas - crear metodo de pago', ['only' => ['store']]);
        $this->middleware('permission:Ventas - mostrar metodo de pago', ['only' => ['show']]);
        $this->middleware('permission:Ventas - editar metodo de pago', ['only' => ['update']]);
        $this->middleware('permission:Ventas - eliminar metodo de pago', ['only' => ['destroy']]);
        $this->salePaymentMethod = $salePaymentMethod;
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
            $result = $this->salePaymentMethod->select('id', 'PaymentMethodName')->get();
            $count = $this->salePaymentMethod->count();
            return response([
                'count' => $count,
                'data' => $result
            ], Response::HTTP_OK);
        }
        $paymentMethods = $this->salePaymentMethod->select('id', 'PaymentMethodName')->paginate();
        return response($paymentMethods, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalePaymentMethodRequest $request)
    {
        $salePaymentMethod = $this->salePaymentMethod->updateOrCreate($request->toArray());
        History::create([
            'action' => 'Ventas - Creando metodo de Pago',
            'model_type' => 'App\Models\SalePaymentMethod',
            'model_id' => $salePaymentMethod->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response([
            'data' => $salePaymentMethod
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalePaymentMethod  $salePaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(SalePaymentMethod $salePaymentMethod)
    {
        return response([
            'data' => $salePaymentMethod
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalePaymentMethod  $salePaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(SalePaymentMethodRequest $request, SalePaymentMethod $salePaymentMethod)
    {
        History::create([
            'action' => 'Ventas - Actualizando metodo de Pago',
            'model_type' => 'App\Models\SalePaymentMethod',
            'model_id' => $salePaymentMethod->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $salePaymentMethod->update($request->all());
        return response([
            'data' => $salePaymentMethod
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalePaymentMethod  $salePaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalePaymentMethod $salePaymentMethod, Request $request)
    {
        History::create([
            'action' => 'Ventas - Eliminando metodo de Pago',
            'model_type' => 'App\Models\SalePaymentMethod',
            'model_id' => $salePaymentMethod->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $salePaymentMethod->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
