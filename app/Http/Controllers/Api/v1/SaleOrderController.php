<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleOrder;
use App\Models\SaleCustomer;
use Illuminate\Http\Request;
use App\Http\Resources\SaleOrderResourceAdmin;
use App\Http\Resources\SaleOrderResourceUser;
use App\Http\Requests\SaleOrderRequest;
use App\Http\Controllers\Controller;

class SaleOrderController extends Controller
{

    protected $saleOrder;
    protected $saleCustomer;

    public function __construct(SaleOrder $saleOrder, SaleCustomer $saleCustomer)
    {
        $this->middleware('api.admin')->except(['store']);
        $this->saleOrder = $saleOrder;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($request->query("orderId") || $request->query("customerId") || $request->query("stateOrder"))
        {
            $value1 = $request->query("orderId");
            $value2 = $request->query("customerId");
            $value3 = $request->query("stateOrderId");
            $query = $this->saleOrder->where('id', '>', 0);
            if($request->query("orderId"))
            {
                $query->where('id', 'like', "$value1");
            }
            if($request->query("stateOrderId"))
            {
                $query->where('sale_state_order_id', "$value3");
            }
            if($request->query("customerId"))
            {
                $query->where("sale_customer_id", "$value2");
            }
            return SaleOrderResourceAdmin::collection($query->orderBy('created_at', 'desc')->paginate()->withQueryString());
        }
        return SaleOrderResourceAdmin::collection($this->saleOrder->orderBy('created_at', 'desc')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleOrderRequest $request)
    {
        $userIdentity = false;
        foreach ($request->user()->roles as $role) {
            if ($role['name'] != 'user')
                $userIdentity = true; 
        }
        $saleCustomer = $this->saleCustomer->firstOrCreate(['user_id' => $request->user()->id],
            [
               'FullName' => $request->user()->name,
               'Phone' => $request->user()->phone,
               'Email' => $request->user()->email,
               'Dni' => $request->user()->dni
            ]);
        $saleStateOrder = $this->saleStateOrder->firstOrCreate(['name' => 'Pendiente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleOrder  $saleOrder
     * @return \Illuminate\Http\Response
     */
    public function show(SaleOrder $saleOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleOrder  $saleOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleOrder $saleOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleOrder  $saleOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleOrder $saleOrder)
    {
        //
    }
}
