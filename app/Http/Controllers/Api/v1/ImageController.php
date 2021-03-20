<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\ImageRequest;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{

    protected $image;

    public function __constructor(Image $image)
    {
        $this->image = image;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {
        $data = [];
        foreach($request->file('image_uploads') as $file)
        {
            $name = Str::uuid() . "." . $file->getClientOriginalExtension();
            $file->move(public_path().'/uploads/', $name);
            $fileModal = new Image();
            $fileModal->name = $name;
            $fileModal->path = '/uploads/'.$name ;
            $fileModal->save();
            $fileModal->original_name = $file->getClientOriginalName();
            $data[] = $fileModal;
        }
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
