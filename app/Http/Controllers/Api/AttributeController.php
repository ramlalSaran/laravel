<?php

namespace App\Http\Controllers\Api;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attribute = Attribute::all();
        // dd($attribute);
        return response()->json([
            'status' => true,
            'message' => 'Customers retrieved successfully',
            'data'    =>$attribute,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $vltddata = Validator::make( $request->all(),[
            
                'name' => 'required',
                'status' => 'required',
                'is_variant'=>'required'
            
        ]);
        if ($vltddata->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation required',
                'errors'=> $vltddata->errors()
            ],401);
        }
        $name_key=preg_replace('/[^a-zA-Z0-9-]+/','-',$request->name);
        $block = Attribute::create([
            'name' =>$request['name'],
            'status' =>$request['status'],
            'is_variant'=>$request['is_variant'],
            'name_key'=>$name_key
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Customer created successfully',
            'data' => $block
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());

        $vltddata = Validator::make( $request->all(),[
            
            'name' => 'required',
            'status' => 'required',
            'is_variant'=>'required'
        
    ]);
    if ($vltddata->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'validation required',
            'errors'=> $vltddata->errors()
        ],400);
    }
    $name_key=preg_replace('/[^a-zA-Z0-9-]+/','-',$request->name);
     Attribute::where('id',$id)->update([
        'name' =>$request->name,
        'status' =>$request->status,
        'is_variant'=>$request->is_variant,
        'name_key'=>$name_key
    ]);
    return response()->json([
        'status' => true,
        'message' => 'Customer created successfully',
        'data' => $block
    ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Attribute::find($id)->delete();
        return response()->json([
            'status' => true,
            'massage' => 'data is deleted ',
            
        ],200);
    }
}
