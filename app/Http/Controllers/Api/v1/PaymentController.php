<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use  App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{

    protected $payment;
    protected $order;
    
    public function __construct(Order $order, Payment $payment)
    {
        $this->middleware('api.admin');
        $this->payment = $payment;
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRequest $request, Order $order)
    {
        $payment = $this->payment->create([
            'image' => $request->image,
            'mount' => $request->mount,
            'payment_date' => $request->payment_date,
            'order_id' => $order->id,
            'payment_concept_id' => $request->payment_concept_id,
            'bank_entity_id' => $request->bank_entity_id,
        ]);
        // $payment = $this->payment->create($request->toArray());
        return response()->json(['message' => 'Payment added successfully']);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentRequest $request, Payment $payment)
    {
        // $payment->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
