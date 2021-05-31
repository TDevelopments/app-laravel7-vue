<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequestAdmin;
use App\Http\Requests\StoreUserRequestAdmin;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Hash;

/**
* @OA\Info(title="API Usuarios", version="1.0")
*
* @OA\Server(url="http://app.test")
*/
class UserController extends Controller
{
    protected $user;
    protected $role;

    public function __construct(User $user, Role $role)
    {
        $this->middleware('api.admin');
        $this->user = $user;
        $this->role = $role;
    }

    /**
    * @OA\Get(
    *     path="/api/v1/users",
    *     summary="Mostrar usuarios",
    *     @OA\Response(
    *         response=200,
    *         description="Mostrar todos los usuarios."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function index(Request $request)
    {
        return UserResource::collection($this->user->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequestAdmin $request)
    {   
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = $this->user->create($request->toArray());
        if ($request['roles'])
        {
            $roles = $request['roles'];
            foreach ($roles as $role)
            {
                $user->roles()->attach(Role::where('name', $role)->first());
            }
        }
        else
            $user->roles()->attach($this->role->where('name', 'user')->first());
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequestAdmin $request, User $user)
    {
        if($request['password'])
        {
            $request['password']=Hash::make($request['password']);
            $request['remember_token'] = Str::random(10);
        }
        if ($request['roles'])
        {
            $user->roles()->detach();
            $roles = $request['roles'];
            if (!$user->hasAnyRole($roles))
            {
                foreach ($roles as $role)
                {
                    if ($user->hasRole($role))
                        continue;
                    else
                        $user->roles()->attach(Role::where('name', $role)->first());
                }
            }
        }
        $user->update($request->toArray());
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
