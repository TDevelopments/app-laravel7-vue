<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleStockRecord;
use App\Models\SaleProduct;
use App\Models\SaleProductStatus;
use App\Models\SaleCustomer;
use Illuminate\Http\Request;
use App\Http\Requests\SaleStockRecordRequest;
use App\Http\Resources\SaleStockRecordResource;
use App\Http\Resources\SaleStockRecordCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class SaleStockRecordController extends Controller
{
    protected $saleStockRecord;
    protected $saleProduct;
    protected $saleCustomer;
    protected $saleProductStatus;

    public function __construct(SaleStockRecord $saleStockRecord, SaleCustomer $saleCustomer, SaleProduct $saleProduct, SaleProductStatus $saleProductStatus)
    {
        $this->middleware('api.admin');
        $this->saleStockRecord = $saleStockRecord;
        $this->saleCustomer = $saleCustomer;
        $this->saleProduct = $saleProduct;
        $this->saleProductStatus = $saleProductStatus;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query('ByCustomer')) {
            $value = $request->query('ByCustomer');
            $saleProductStatus = $this->saleProductStatus->firstWhere('StatusName', 'Reservado');
            $consult = $this->saleStockRecord->where('sale_product_status_id', $saleProductStatus->id)->where('sale_customer_id', $value)->paginate()->withQueryString();
            return SaleStockRecordResource::collection($consult);
        }
        if ($request->query("BusinessId") || $request->query("StatusId") || $request->query("ProductName") || $request->query("CustomerName")) {
            $value1 = $request->query("BusinessId");
            $value2 = $request->query("StatusId");
            $value3 = $request->query("ProductName");
            $value4 = $request->query("CustomerName");
            $query = $this->saleStockRecord->where('Quantity', '>', 0);
            if($request->query("BusinessId"))
            {
                $query->where('sale_business_location_id', $value1);
            }
            if($request->query("StatusId"))
            {
                $query->where("sale_product_status_id", $value2);
            }
            if($request->query("ProductName"))
            {
                $productReference = $this->saleProduct->firstWhere("ProductName", "like", "%$value3%");
                if (!empty($productReference))
                    $query->where("sale_product_id", $productReference->id);
            }
            if($request->query("CustomerName"))
            {
                // $customerReference = $this->saleCustomer->where("FirstName", "like", "%$value4%")->orWhere("LastName", "like", "%$value4%")->first();
                $customerReference = $this->saleCustomer->where('FullName', 'like', "%$value4%")->first();
                if (!empty($customerReference))
                    $query->where("sale_customer_id", $customerReference->id);
            }
            return new SaleStockRecordCollection($query->orderBy('created_at', 'desc')->paginate()->withQueryString());
        }
        $saleStockRecords = $this->saleStockRecord->where('Quantity', '>', 0)->orderBy('created_at', 'desc')->paginate();
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
        $saleStockRecord->update(['order_detail_id' => NULL]);
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
