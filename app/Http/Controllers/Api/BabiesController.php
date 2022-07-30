<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Baby;
use Illuminate\Http\Request;
use Throwable;

class BabiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parents = Baby::all();
        return response()->json([
            $parents
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json([
            Baby::create(array_merge($request->all(), ['parent_id' =>  $request->user()->id]))
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Baby $baby)
    {
        return response()->json([
            $baby
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Baby $baby)
    {
        $baby->update(array_merge($request->all(), ['parent_id' =>  $request->user()->id]));
        return response()->json([
            $baby
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Baby $baby)
    {
        try {
            if ($baby->parent_id == request()->user()->id) {
                $baby->delete();
                return response()->json(['message' => 'deleted']);
            }else{
                return response()->json(['error' => 'You cannot delete this child'], 400);
            }
        } catch (Throwable $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }
}
