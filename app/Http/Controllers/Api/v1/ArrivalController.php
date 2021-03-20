<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Arrival;
use App\Models\Catalogue;
use App\Http\Requests\ArrivalRequest;
use App\Http\Resources\ArrivalResource;
use Illuminate\Support\Facades\Validator;

class ArrivalController extends Controller
{

    protected $arrival;
    /** */
    public function __construct(Arrival $arrival)
    {
        $this->middleware('api.admin');
        $this->arrival = $arrival;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(ArrivalRequest $request, Catalogue $catalogue)
    // {
    //     $arrival = $this->arrival->firstOrCreate(
    //         [
    //         'city' => $request->city,
    //         'catalogue_id' => $catalogue->id,
    //         ],
    //         [
    //         'arrival_date' => $request->arrival_date,
    //         ]
    //     );
    //     return new ArrivalResource($arrival);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Catalogue $catalogue)
    {
        $validator = Validator::make($request->all(), [
            'items.*.city' => 'required',
            'items.*.arrival_date' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $data = $request->items;
        $arrivals = array();
        foreach($data as $row) { 
            $arrivals[] = $this->arrival->updateOrCreate([
                'city' => $row['city'],
                'catalogue_id' => $catalogue->id], ['arrival_date' => $row['arrival_date']]);
        }
        return ArrivalResource::collection($arrivals);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // public function destroy(Catalogue $catalogue, Arrival $arrival)
    // {
    //     $arrival->delete();
    //     return response()->json(null, 204);
    // }

    // public function destroy(Arrival $arrival)
    // {
    //     $arrival->delete();
    //     return response()->json(null, 204);
    // }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => ['required', 'array'],
            'items.*' => ['required', 'integer','exists:App\Models\Arrival,id'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $this->arrival->destroy($request->items);
        return response()->json(['success'=>"Arrivals Deleted successfully."]);
    }
}
