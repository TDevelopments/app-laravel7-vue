<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleCustomer;
use Illuminate\Http\Request;
use App\Http\Requests\SaleCustomerRequest;
use App\Http\Resources\SaleCustomerResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class SaleCustomerController extends Controller
{
    protected $saleCustomer;

    /**
     * Constructor
     *
     * @param \App\Models\SaleCategory $saleCategory
     */
    public function __construct(SaleCustomer $saleCustomer)
    {
        $this->middleware('api.admin')->except(['store']);
        $this->saleCustomer = $saleCustomer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $saleCustomer = $this->saleCustomer->paginate();
        return SaleCustomerResource::collection($saleCustomer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $saleCustomer = $this->saleCustomer->create($request->toArray());
        return response([
            'data' => new SaleCustomerResource($saleCategory)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleCustomer  $saleCustomer
     * @return \Illuminate\Http\Response
     */
    public function show(SaleCustomer $saleCustomer)
    {
        return new SaleCustomerResource($saleCustomer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleCustomer  $saleCustomer
     * @return \Illuminate\Http\Response
     */
    public function update(SaleCustomerRequest $request, SaleCustomer $saleCustomer)
    {
        $saleCustomer->update($request->all());
        return response([
            'data' => new SaleCustomerResource($saleCustomer)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleCustomer  $saleCustomer
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleCustomer $saleCustomer)
    {
        $saleCategory->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
