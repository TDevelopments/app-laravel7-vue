<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleProductUnit;
use Illuminate\Http\Request;
use App\Http\Requests\SaleProductUnitRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class SaleProductUnitController extends Controller
{
    protected $saleProductUnit;

    /**
     * Constructor
     *
     * @param \App\Models\SaleCategory $saleCategory
     */
    public function __construct(SaleProductUnit $saleProductUnit)
    {
        $this->middleware('api.admin');
        $this->saleProductUnit = $saleProductUnit;
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
            $result = $this->saleProductUnit->get();
            $count = $this->saleProductUnit->count();
            return response([
                'count' => $count,
                'data' => $result
            ], Response::HTTP_OK);
        }
        $saleProductUnit = $this->saleProductUnit->paginate();
        return response($saleProductUnit, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleProductUnitRequest $request)
    {
        $saleProductUnit = $this->saleProductUnit->updateOrCreate($request->toArray());
        return response([
            'data' => $saleProductUnit
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleProductUnit  $saleProductUnit
     * @return \Illuminate\Http\Response
     */
    public function show(SaleProductUnit $saleUnit)
    {
        return response([
            'data' => $saleUnit
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleProductUnit  $saleProductUnit
     * @return \Illuminate\Http\Response
     */
    public function update(SaleProductUnitRequest $request, SaleProductUnit $saleUnit)
    {
        $saleUnit->update($request->all());
        return response([
            'data' => $saleUnit
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleProductUnit  $saleProductUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleProductUnit $saleUnit)
    {
        $saleUnit->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
