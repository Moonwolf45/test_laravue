<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SectionController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $sections = Sections::with('users')->get();

        if ($sections) {
            $sections->toArray();
        } else {
            $sections = [];
        }

        return response()->json(['sections' => $sections], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $section = new Sections();
        $section->name = $request->name;
        $section->description = $request->description;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('logo');
            $section->logo = '/' . $path;
        }
        $section->save();

        if ($request->users) {
            $usersArr = explode(',', $request->users);

            $section->users()->attach($usersArr);
        }

        return response()->json(['new_section' => $section], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $section = Sections::with('users')->where('id', $id)->first();
        return response()->json(['section' => $section], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $section = Sections::where('id', $id)->first();
        $section->name = $request->name;
        $section->description = $request->description;
        if ($request->hasFile('image')) {
            Storage::disk('public_image')->delete($section->logo);
            $path = $request->file('image')->store('logo');
            $section->logo = '/' . $path;
        }
        $section->save();

        if ($request->users) {
            $usersArr = explode(',', $request->users);

            $section->users()->sync($usersArr);
        }

        return response()->json(['update_section' => $section], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        $section = Sections::where('id', $id)->first();
        if ($section->logo != 0) {
            Storage::disk('public_image')->delete($section->logo);
        }
        $res = $section->delete();

        return response()->json(['status' => $res], 200);
    }
}
