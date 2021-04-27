<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleBrand;
use Illuminate\Http\Request;
use App\Http\Requests\SaleBrandRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class SaleBrandController extends Controller
{
    protected $saleBrand;

    /**
     * Constructor
     *
     * @param \App\Models\SaleCategory $saleCategory
     */
    public function __construct(SaleBrand $saleBrand)
    {
        $this->middleware('api.admin')->except(['store']);
        $this->saleBrand = $saleBrand;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $saleBrands = $this->saleBrand->paginate();
        return response($saleBrands, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleBrandRequest $request)
    {
        $saleBrand = $this->saleBrand->updateOrCreate($request->toArray());
        return response([
            'data' => $saleBrand
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleBrand  $saleBrand
     * @return \Illuminate\Http\Response
     */
    public function show(SaleBrand $saleBrand)
    {
        return response([
            'data' => $saleBrand
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleBrand  $saleBrand
     * @return \Illuminate\Http\Response
     */
    public function update(SaleBrandRequest $request, SaleBrand $saleBrand)
    {
        $saleBrand->update($request->all());
        return response([
            'data' => $saleBrand
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleBrand  $saleBrand
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleBrand $saleBrand)
    {
        $saleBrand->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
