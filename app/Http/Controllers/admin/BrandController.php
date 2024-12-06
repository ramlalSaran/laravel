<?php

namespace App\Http\Controllers\admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Brand::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('brand_image', function ($row) {
                    $brand_image = $row->brand_image; // Assuming this contains the image filename
                    // dd($brand_image);
        
                    if ($brand_image) {
                        // Generate the public URL for the image
                        $brand_image = asset('storage/' . $brand_image);
                        
        
                        // Return the HTML to display the image
                        return "<img src='$brand_image' alt='Brand Image' style='width: 70px; height: 70px;'>";
                    } else {
                        return 'No brand image available';
                    }
                })
                ->addColumn('status', function ($row) {
                    return $row->status == 1 ? 'Enable' : 'Disable';
                })
                ->addColumn('action', function ($row) {
                    return $editBtn = '<a class="dropdown-item" href="' . route('brand.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a>';
                })
                ->rawColumns(['brand_image', 'action']) // Use 'brand_image' for rendering HTML
                ->make(true);
        }
        
        return view('admin.brands.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' =>'required|max:20',
            'brand_image' => 'required',
            'status'   => 'required'
        ]);

        if ($request->hasFile('brand_image')) {
            $brand_image = $request->file('brand_image')->store('brands','public');
            
        }
        Brand::create([
            'title' => $validate['title'],
            'brand_image' =>$brand_image,
            'status' => $validate['status']
        ]);
        return redirect()->route('brand.index');
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
        $brand = Brand::where('id',$id)->first();
        return view('admin.brands.edit',compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'title' => 'required|max:20',
            'brand_image' => 'required', // Add validation for image
            'status' => 'required'
        ]);
        
        // Find the existing brand record
        $brand = Brand::find($id);
        
        if ($request->hasFile('brand_image')) {
            // Delete the previous image if it exists
            if ($brand && $brand->brand_image) {
                $oldImagePath = storage_path('app/public/' . $brand->brand_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Delete the file
                }
            }
            // Store the new image
            $brand_image = $request->file('brand_image')->store('brands', 'public');
            // Update the database with the new image path
            $brand->brand_image = $brand_image;
        }
        Brand::where('id',$id)->update([
            'title' => $validate['title'],
            'brand_image' => $brand_image,
            'status' =>$validate['status'],
        ]);
        
        return redirect()->route('brand.index')->with('success', 'Brand updated successfully!');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
