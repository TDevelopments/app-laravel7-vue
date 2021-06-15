<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SalePayment;
use App\Models\SalePaymentMethod;
use App\Models\SalePaymentStatus;
use App\Models\SaleOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\SalePaymentRequest;
use App\Http\Resources\SaleOrderResourceAdmin;

class SalePaymentController extends Controller
{

    protected $salePayment;
    protected $saleOrder;
    protected $salePaymentMethod;
    protected $salePaymentStatus;
    
    public function __construct(SaleOrder $saleOrder, SalePayment $salePayment, SalePaymentMethod $salePaymentMethod, SalePaymentStatus $salePaymentStatus)
    {
        $this->middleware('api.admin');
        $this->middleware('permission:Ventas - crear pago de orden', ['only' => ['store']]);
        $this->middleware('permission:Ventas - actualizar pago de orden', ['only' => ['update']]);
        $this->middleware('permission:Ventas - eliminar pago de orden', ['only' => ['destroy']]);
        $this->salePayment = $salePayment;
        $this->saleOrder = $saleOrder;
        $this->salePaymentMethod = $salePaymentMethod;
        $this->salePaymentStatus = $salePaymentStatus;
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
    public function store(SalePaymentRequest $request, SaleOrder $saleOrder)
    {
        $salePaymentMethod = $this->salePaymentMethod->find($request->PaymentMethodId);
        $salePaymentStatus = $this->salePaymentStatus->find($request->PaymentStatusId);
        $salePayment = $this->salePayment->create([
            'sale_order_id' => $saleOrder->id,
            'sale_payment_method_id' => $salePaymentMethod->id,
            'sale_payment_status_id' => $salePaymentStatus->id,
            'TotalAmount' => $saleOrder->SaleOrderDetails->sum('Total'),
            'TotalPaid' => $request->TotalPaid,
            'SellNote' => $request->SellNote,
            'user_id' => $request->user()->id
        ]);
        return new SaleOrderResourceAdmin($saleOrder);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalePayment  $salePayment
     * @return \Illuminate\Http\Response
     */
    public function show(SalePayment $salePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalePayment  $salePayment
     * @return \Illuminate\Http\Response
     */
    public function update(SalePaymentRequest $request, SaleOrder $saleOrder)
    {
        $salePaymentMethod = $this->salePaymentMethod->find($request->PaymentMethodId);
        $salePaymentStatus = $this->salePaymentStatus->find($request->PaymentStatusId);
        $saleOrder->salePayment->update([
            'sale_payment_method_id' => $salePaymentMethod->id,
            'sale_payment_status_id' => $salePaymentStatus->id,
            'TotalAmount' => $saleOrder->SaleOrderDetails->sum('Total'),
            'TotalPaid' => $request->TotalPaid,
            'SellNote' => $request->SellNote,
            'user_id' => $request->user()->id
        ]);
        return new SaleOrderResourceAdmin($saleOrder);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalePayment  $salePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalePayment $salePayment)
    {
        $salePayment->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
