<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Adviser;
use App\Http\Requests\AdviserRequest;
use Illuminate\Http\Request;
use App\Http\Resources\AdviserResource;
use App\Http\Controllers\Controller;

class AdviserController extends Controller
{
    protected $adviser;

    public function __construct(Adviser $adviser)
    {
        $this->middleware('api.admin');
        $this->adviser = $adviser;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AdviserResource::collection($this->adviser->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdviserRequest $request)
    {
        $adviser = $this->adviser->create($request->toArray());
        return new AdviserResource($adviser);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Adviser  $adviser
     * @return \Illuminate\Http\Response
     */
    public function show(Adviser $adviser)
    {
        return new AdviserResource($adviser);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Adviser  $adviser
     * @return \Illuminate\Http\Response
     */
    public function update(AdviserRequest $request, Adviser $adviser)
    {
        $adviser->update($request->toArray());
        return new AdviserResource($adviser);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Adviser  $adviser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adviser $adviser)
    {
        $adviser->delete();
        return response()->json(null, 204);
    }
}
