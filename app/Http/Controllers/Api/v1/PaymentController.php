<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{

    protected $payment;
    protected $order;
    
    public function __construct(Order $order, Payment $payment)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Importaciones - crear y actualizar pagos orden', ['only' => ['store']]);
        $this->middleware('permission:Importaciones - eliminar pagos orden', ['only' => ['destroy']]);
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
     * Store a newly created resource in storage.    *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'payments.*.nro_operation' => ['required', 'string'],
            'payments.*.dollar_price' => ['required', 'numeric'],
            'payments.*.type_coin' => ['required', 'string', 'in:soles,dolares'],
            'payments.*.image' => ['required'],
            'payments.*.image.id' => ['required', 'integer', 'exists:App\Models\Image,id'],
            'payments.*.image.name' => ['required', 'exists:App\Models\Image,name'],
            'payments.*.image.path' => ['required', 'exists:App\Models\Image,path'],
            'payments.*.mount' => ['required', 'numeric'],
            'payments.*.payment_date' => ['required', 'date'],
            'payments.*.payment_concept_id' => ['required', 'exists:App\Models\PaymentConcept,id'],
            'payments.*.bank_entity_id' => ['required', 'exists:App\Models\BankEntity,id'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $data = $request['payments'];
        $payments = array();
        foreach($data as $row)
        {
            /* if (strpos($foo, 'mundo') !== false) { */
            /*     echo 'true'; */
            /* } */
          /* $paymentConceptReference = $this->paymentConcept->find($row['payment_concept_id']); */
          /* $ordersDetails = $this->orderDetail->where('order_id', $order->id)->get(); */
          /* foreach($ordersDetails as $orderDetail) */
          /* { */
          /*     if (is_null($orderDetail->product_id)) */
          /*         $this->productRange->find($orderDetail->product_range_id)->decrement('count', (int)$orderDetail->quantity); */
          /*     else */
          /*         $this->product->find($orderDetail->product_id)->decrement('count', (int)$orderDetail->quantity); */
          /* } */
          $payments[] = $this->payment->updateOrCreate(
            [
              'order_id' => $order->id,
              'payment_concept_id' => $row['payment_concept_id'],
            ],[
              'image' => $row['image'],
              'nro_operation' => $row['nro_operation'],
              'dollar_price' => $row['dollar_price'],
              'type_coin' => $row['type_coin'],
              'mount' => $row['mount'],
              'payment_date' => $row['payment_date'],
              'bank_entity_id' => $row['bank_entity_id'],
              'user_id' => $request->user()->id,
            ]);
        }
        return PaymentResource::collection($payments);
        // $payment = $this->payment->create([
        //     'image' => $request->image,
        //     'mount' => $request->mount,
        //     'payment_date' => $request->payment_date,
        //     'order_id' => $order->id,
        //     'payment_concept_id' => $request->payment_concept_id,
        //     'bank_entity_id' => $request->bank_entity_id,
        // ]);
        // $payment = $this->payment->create($request->toArray());
        // return response()->json(['message' => 'Payment added successfully']);
        
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
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payments' => ['required', 'array'],
            'payments.*' => ['required', 'integer','exists:App\Models\Payment,id'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $this->payment->destroy($request->payments);
        return response()->json(['success'=>"Arrivals Deleted successfully."]);
    }
}
