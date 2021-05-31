<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SalePaymentStatus;
use Illuminate\Http\Request;
use App\Http\Requests\SalePaymentStatusRequest;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class SalePaymentStatusController extends Controller
{

    protected $salePaymentStatus;

    public function __construct(SalePaymentStatus $salePaymentStatus)
    {
        $this->middleware('api.admin');
        $this->salePaymentStatus = $salePaymentStatus;
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
            $result = $this->salePaymentStatus->select('id', 'PaymentStatusName')->get();
            $count = $this->salePaymentStatus->count();
            return response([
                'count' => $count,
                'data' => $result
            ], Response::HTTP_OK);
        }
        $paymentStatus = $this->salePaymentStatus->select('id', 'PaymentStatusName')->paginate();
        return response($paymentStatus, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalePaymentStatusRequest $request)
    {
        $salePaymentStatus = $this->salePaymentStatus->updateOrCreate($request->toArray());
        return response([
            'data' => $salePaymentStatus
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalePaymentStatus  $salePaymentStatus
     * @return \Illuminate\Http\Response
     */
    public function show(SalePaymentStatus $salePaymentStatus)
    {
        return response([
            'data' => $salePaymentStatus
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalePaymentStatus  $salePaymentStatus
     * @return \Illuminate\Http\Response
     */
    public function update(SalePaymentStatusRequest $request, SalePaymentStatus $salePaymentStatus)
    {
        $salePaymentStatus->update($request->all());
        return response([
            'data' => $salePaymentStatus
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalePaymentStatus  $salePaymentStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalePaymentStatus $salePaymentStatus)
    {
        $salePaymentStatus->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
