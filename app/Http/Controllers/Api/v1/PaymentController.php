<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'mount' => ['required', 'numeric'],
            'payment_date' => ['required', 'date'],
            'image' => ['required'],
            'image.id' => ['required', 'exists:App\Models\Image,id'],
            'image.name' => ['required', 'exists:App\Models\Image,name'],
            'image.path' => ['required', 'exists:App\Models\Image,path'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $payment = $this->payment->create([
            'image' => $request->image,
            'mount' => $request->mount,
            'payment_date' => $request->payment_date,
            'order_id' => $order->id,
        ]);
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
    public function update(Request $request, Payment $payment)
    {
        //
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
