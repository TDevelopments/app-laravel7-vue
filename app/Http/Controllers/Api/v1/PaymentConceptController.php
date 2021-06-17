<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\PaymentConcept;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentConceptRequest;
use App\Http\Controllers\Controller;
use App\Models\History;
use Carbon\Carbon;

class PaymentConceptController extends Controller
{
    protected $concept;

    public function __construct(PaymentConcept $concept)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Importaciones - listar conceptos de pago', ['only' => ['index']]);
        $this->middleware('permission:Importaciones - crear concepto de pago', ['only' => ['store']]);
        $this->middleware('permission:Importaciones - mostrar concepto de pago', ['only' => ['show']]);
        $this->middleware('permission:Importaciones - editar concepto de pago', ['only' => ['update']]);
        $this->middleware('permission:Importaciones - eliminar concepto de pago', ['only' => ['destroy']]);
        $this->concept = $concept;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->concept->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentConceptRequest $request)
    {
        $concept = $this->concept->create($request->toArray());
        History::create([
            'action' => 'Creando concepto de pago',
            'model_type' => 'App\Models\PaymentConcept',
            'model_id' => $concept->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response()->json($concept, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentConcept  $concept
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentConcept $paymentConcept)
    {
        return response()->json($paymentConcept, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentConcept  $concept
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentConceptRequest $request, PaymentConcept $paymentConcept)
    {
        History::create([
            'action' => 'Actualizando concepto de pago',
            'model_type' => 'App\Models\PaymentConcept',
            'model_id' => $paymentConcept->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $paymentConcept->update($request->toArray());
        return response()->json($paymentConcept, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentConcept  $concept
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentConcept $paymentConcept, Request $request)
    {
        History::create([
            'action' => 'Eliminando concepto de pago',
            'model_type' => 'App\Models\PaymentConcept',
            'model_id' => $paymentConcept->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $paymentConcept->delete();
        return response()->json(null, 204);
    }
}
