<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Baby;
use App\Models\Parent_;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ParentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $parent = null;



    public function login(Request $request)
    {
        $user = Parent_::where('name', $request->name)->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided name is incorrect.'],
            ]);
        }
        return $user->createToken($request->name)->plainTextToken;
    }

    public function index()
    {
        $parents = Parent_::all();
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
            Parent_::create(array_merge($request->all(), ['parent_id' =>  $request->user()->id]))
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Parent_ $parent)
    {
        return response()->json([
            $parent
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parent_ $parent)
    {
        $parent->update(array_merge($request->all(), ['parent_id' =>  $request->user()->id]));
        return response()->json([
            $parent
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parent_ $parent)
    {
        try {
            $parent->delete();
            return response()->json(['message' => 'deleted']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }


    public function getPartners($id)
    {
        $parent = Parent_::find($id);
        if ($parent->parent_id) {
            return response()->json(['message' => 'This User has no Partners']);
        } else {
            return response()->json([
                $parent->children
            ]);
        }
    }
    public function getChildrens($id)
    {
        $parent = Parent_::find($id);
        if ($parent->parent_id) {
            $super_parent=Parent_::find($parent->parent->id);
            $childs=$super_parent->children->pluck('id')->toArray();
            $childrens = Baby::whereIn('parent_id', array_merge([$parent->parent->id],$childs))->get();
        } else {
            $childs=$parent->children->pluck('id')->toArray();
            $childrens = Baby::whereIn('parent_id', array_merge([$parent->id],$childs))->get();
        }
        return response()->json([
            $childrens
        ]);
    }
}
