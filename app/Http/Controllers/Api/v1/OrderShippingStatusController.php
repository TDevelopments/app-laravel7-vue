<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderShippingStatus;
use App\Http\Requests\OrderShippingStatusRequest;

class OrderShippingStatusController extends Controller
{
    protected $shippingStatus;

    public function __construct(OrderShippingStatus $shippingStatus)
    {
        $this->middleware('api.admin');
        $this->shippingStatus = $shippingStatus;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->shippingStatus->paginate(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderShippingStatusRequest $request)
    {
        $shippingStatus = $this->shippingStatus->create($request->toArray());
        return response()->json($shippingStatus, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OrderShippingStatus $orderShippingStatus)
    {
        return response()->json($orderShippingStatus, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderShippingStatusRequest $request, OrderShippingStatus $orderShippingStatus)
    {
        $orderShippingStatus->update($request->toArray());
        return response()->json($orderShippingStatus, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderShippingStatus $orderShippingStatus)
    {
        $orderShippingStatus->delete();
        return response()->json(null, 204);
    }
}
