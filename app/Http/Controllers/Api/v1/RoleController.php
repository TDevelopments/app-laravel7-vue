<?php

namespace App\Http\Controllers\Api\v1;

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    
    protected $role;

    /**
     * Constructor
     *
     * @param \App\Models\Role $role.
     */
    public function __construct(Role $role)
    {
        $this->middleware('api.admin');
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* return response()->json(["data" => $this->role->all()]); */
        if ($request->query("list")) {
            $value = $request->query("list");
            $result = $this->role->get();
            return response([
                'data' => $result
            ], Response::HTTP_OK);
        }
        $roles = $this->role->paginate();
        return response($roles, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = $this->role->updateOrCreate([ 'name' => $request->name ]);
        return response([
            'data' => $role
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return response([
            'data' => $role
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role->update($request->all());
        return response([
            'data' => $role
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
