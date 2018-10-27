<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\StringHelper;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereActive(1)->get();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email'
        ];
        $this->validate($request, $rules);

        $stringHelper = new StringHelper();

        $user = new User;
        $user->name = $stringHelper->toUpperCase($request->name);
        $user->email = $stringHelper->toLowerCase($request->email);
        $user->active = 1;
        $user->save();

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::whereActive(1)->findOrFail($id);

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'active' => 'required|numeric|max:1|min:0'
        ];
        $this->validate($request, $rules);

        $stringHelper = new StringHelper();

        $user = User::findOrFail($id);
        $user->name = $stringHelper->toUpperCase($request->name);
        $user->email = $stringHelper->toLowerCase($request->email);
        $user->active = $request->active;

        if ($user->isDirty()) {
            $user->save();
        }

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        response()->json($user);
    }
}
