<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index () {
        $users = User::all();

        if ($users) {
            $users->toArray();
        } else {
            $users = [];
        }

        return response()->json(['users' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|max:255',
            "email" => 'required|string|max:255',
            "password" => 'required|string|min:6|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(10);
        $user->save();

        return response()->json(['new_user' => $user], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show ($id) {
        $user = User::where('id', $id)->first();
        return response()->json(['user' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update (Request $request, $id) {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|max:255',
            "email" => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $user = User::where('id', $id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != '') {
            $user->password = $request->password;
        }
        $user->save();

        return response()->json(['update_user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy ($id) {
        $res = User::where('id', $id)->delete();

        return response()->json(['status' => $res], 200);
    }
}
