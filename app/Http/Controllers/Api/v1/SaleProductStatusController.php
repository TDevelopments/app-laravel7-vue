<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleProductStatus;
use Illuminate\Http\Request;
use App\Http\Requests\SaleProductStatusRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class SaleProductStatusController extends Controller
{
    protected $saleProductStatus;

    /**
     * Constructor
     *
     * @param \App\Models\SaleProductStatus $saleProductStatus 
     */
    public function __construct(SaleProductStatus $saleProductStatus)
    {
        $this->middleware('api.admin');
        $this->saleProductStatus = $saleProductStatus;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $saleProductStatuses = $this->saleProductStatus->paginate();
        return response($saleProductStatuses, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleProductStatusRequest $request)
    {
        $saleProductStatus = $this->saleProductStatus->updateOrCreate($request->toArray());
        return response([
            'data' => $saleProductStatus
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleProductStatus  $saleProductStatus
     * @return \Illuminate\Http\Response
     */
    public function show(SaleProductStatus $saleProductStatus)
    {
        return response([
            'data' => $saleProductStatus
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleProductStatus  $saleProductStatus
     * @return \Illuminate\Http\Response
     */
    public function update(SaleProductStatusRequest $request, SaleProductStatus $saleProductStatus)
    {
        $saleProductStatus->update($request->all());
        return response([
            'data' => $saleProductStatus
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleProductStatus  $saleProductStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleProductStatus $saleProductStatus)
    {
        $saleProductStatus->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
