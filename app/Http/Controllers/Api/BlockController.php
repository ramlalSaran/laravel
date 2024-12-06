<?php

namespace App\Http\Controllers\Api;

use App\Models\Block;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $block = Block::all();
        return response()->json([
            'status' => true,
            'message' => 'Customers retrieved successfully',
            'data' => $block
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'heading' => 'required',
            'description' => 'required',
            'ordering' => 'required'
        ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validate->errors()
                ], 401);
            }
       $heading = $request->heading;
        $idnt = strtolower($heading);
        $identifier = preg_replace('/[^a-zA-Z0-9-]+/', '-', $idnt);
        
        $block = Block::create([
            'identifier'      => $identifier,
            'title'           => $request->title,
            'heading'         => $request->heading,
            'description'     => $request->description,
            'ordering'        => $request->ordering,
            'status'          => $request->status
        ]);
        if ($request->hasFile('banner_image') && $request->file('banner_image')->isValid()) 
        {
            $block->addMediaFromRequest('banner_image')->toMediaCollection('banner_image');
        }
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
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'heading' => 'required',
            'description' => 'required',
            'ordering' => 'required'
        ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validate->errors()
                ], 422);
            }
        $heading = $request->heading;
        $idnt = strtolower($heading);
        $identifier = preg_replace('/[^a-zA-Z0-9-]+/', '-', $idnt);
            
            $block = Block::create([
                'identifier'      => $identifier,
                'title'           => $request->title,
                'heading'         => $request->heading,
                'description'     => $request->description,
                'ordering'        => $request->ordering,
                'status'          => $request->status
            ]);
            if ($request->hasFile('banner_image') && $request->file('banner_image')->isValid()) 
            {
                $block->addMediaFromRequest('banner_image')->toMediaCollection('banner_image');
            }
            return response()->json([
                'status' => true,
                'message' => 'Customer created successfully',
                'data' => $block
            ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Block::where('id',$id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Block deleted successfully'
        ], 200);
    }
}
