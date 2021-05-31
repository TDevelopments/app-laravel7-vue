<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SalePaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalePaymentMethodRequest;
use Symfony\Component\HttpFoundation\Response;

class SalePaymentMethodController extends Controller
{

    protected $salePaymentMethod;

    public function __construct(SalePaymentMethod $salePaymentMethod)
    {
        $this->middleware('api.admin');
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
    public function destroy(SalePaymentMethod $salePaymentMethod)
    {
        $salePaymentMethod->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
