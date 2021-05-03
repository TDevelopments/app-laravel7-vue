<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleStockRecord;
use Illuminate\Http\Request;
use App\Http\Requests\SaleStockRecordRequest;
use App\Http\Resources\SaleStockRecordResource;
use App\Http\Resources\SaleStockRecordCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class SaleStockRecordController extends Controller
{
    protected $saleStockRecord;

    public function __construct(SaleStockRecord $saleStockRecord)
    {
        $this->middleware('api.admin');
        $this->saleStockRecord = $saleStockRecord;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query("BusinessId") && $request->query("StatusId")) {
            $value1 = $request->query("BusinessId");
            $value2 = $request->query("StatusId");
            $result = $this->saleStockRecord->where('sale_business_location_id', $value1)
                        ->where('sale_product_status_id', $value2)
                        ->paginate()->withQueryString();
            return new SaleStockRecordCollection($result);
        }
        if ($request->query("BusinessId")) {
            $value = $request->query("BusinessId");
            $result = $this->saleStockRecord->where('sale_business_location_id', $value)->get();
            $count = $this->saleStockRecord->where('sale_business_location_id', $value)->count();
            return response([
                'data' => $result,
                'count' => $count
            ], Response::HTTP_OK);
        }
        $saleStockRecords = $this->saleStockRecord->paginate();
        return SaleStockRecordResource::collection($saleStockRecords);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleStockRecordRequest $request)
    {
        $saleStockRecord = $this->saleStockRecord->create($request->toArray());
        return response([
            'data' => new SaleStockRecordResource($saleStockRecord)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleStockRecord  $saleStockRecord
     * @return \Illuminate\Http\Response
     */
    public function show(SaleStockRecord $saleStockRecord)
    {
        return new SaleStockRecordResource($saleStockRecord);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleStockRecord  $saleStockRecord
     * @return \Illuminate\Http\Response
     */
    public function update(SaleStockRecordRequest $request, SaleStockRecord $saleStockRecord)
    {
        $saleStockRecord->update($request->all());
        return response([
            'data' => new SaleStockRecordResource($saleStockRecord)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleStockRecord  $saleStockRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleStockRecord $saleStockRecord)
    {
        $saleStockRecord->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
