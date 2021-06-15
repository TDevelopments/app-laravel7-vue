<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\PaymentConcept;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentConceptRequest;
use App\Http\Controllers\Controller;

class PaymentConceptController extends Controller
{
    protected $concept;

    public function __construct(PaymentConcept $concept)
    {
        $this->middleware('api.admin');
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
        $paymentConcept->update($request->toArray());
        return response()->json($paymentConcept, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentConcept  $concept
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentConcept $paymentConcept)
    {
        $paymentConcept->delete();
        return response()->json(null, 204);
    }
}
