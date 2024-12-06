<?php

namespace App\Http\Controllers\admin;
use Gate;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('category_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        if ($request->ajax()) {
            $data = Category::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                   return $row->status == 1 ? 'Enable' : 'Disable';
                })

                ->addColumn('category_image', function ($row) {
                    $category_image = $row->getFirstMediaUrl('category_image');
                    return $category_image 
                        ? "<img src='$category_image' alt='category_image' style='width: 70px; height: 70px;'>" : 'No image';
                })

                ->addColumn('show_in_menu', function ($row) {
                   return $row->show_in_menu == 1 ? 'Yes' : 'No';
                })

                ->addColumn('action', function ($row) {
                   $viewBtn='';
                    if (auth()->user()->can('category_show')) {
                        $viewBtn = '<a class="dropdown-item" href="' . route('category.show', $row->id) . '">
                                        <i class="fas fa-eye"></i> View
                                    </a>';
                    }
                    $editBtn='';
                    if(auth()->user()->can('category_edit')){
                        $editBtn = '<a class="dropdown-item" href="' . route('category.edit', $row->id) . '">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>';
                    }
                    $deleteBtn='';
                    if (auth()->user()->can('category_delete')) {
                        $deleteBtn = '<form action="'. route('category.destroy', $row->id) .'" method="POST" style="display:inline;">
                            '. csrf_field() .'
                            '. method_field("DELETE") .'
                            <button type="submit" class="dropdown-item" onclick="return confirm(\'Are you sure you want to delete this category?\');">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>';
                    }

                    $dropdown = '<div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                        </button>
                        <div class="dropdown-menu">
                            ' . $viewBtn . '
                            ' . $editBtn . '
                            <div class="dropdown-divider"></div>
                            ' . $deleteBtn . '
                        </div>
                    </div>';
    
                    return $dropdown;
                })
                
                
                ->rawColumns(['action','category_image'])
                ->make(true);
        }
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('category_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $products=Product::where('status',1)->get();
        $categories=Category::all();
        return view('admin.categories.create',compact('categories','products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('category_store'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $validatedData = $request->validate([
            'parent_category'       => 'required',
            'name'                  => 'required|string|max:255',
            'status'                => 'required ',
            'show_in_menu'          => 'required ',
            'meta_tag'              => 'required|string|max:255',
            'meta_title'            => 'required|string|max:255',
            'meta_description'      => 'required|string',
            'short_description'     => 'required|string',
            'description'           => 'required|string',
        ]);
        $name=$validatedData['name'];
        $url_key=strtolower($name);
        $url_key=preg_replace('/[^a-zA-Z0-9-]+/', '-', $url_key);

        $create=Category::create([
            'parent_category'          => $validatedData['parent_category'],
            'name'                     => $validatedData['name'],
            'status'                   => $validatedData['status'],
            'show_in_menu'             => $validatedData['show_in_menu'],
            'url_key'                  => $url_key,
            'meta_tag'                 => $validatedData['meta_tag'],
            'meta_title'               => $validatedData['meta_title'],
            'meta_description'         => $validatedData['meta_description'],
            'short_description'        => $validatedData['short_description'],
            'description'              => $validatedData['description'],
        ]);

        $create->products()->sync($request->products);
        
        if ($create) 
        {
            return redirect()->route('category.index')->with('success','Category add successfully...');
        }else{
            return back()->with('error', 'Something went wrong:');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('category_show'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $category = Category::where('id',$id)->first();
        return view('admin.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('category_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $categories = Category::all();
        $products   = Product::where('status',1)->get();
        $category   = Category::where('id',$id)->first();
        return view('admin.categories.edit',compact('category','categories','products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('category_update'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        // dd($request->all());
        $validatedData = $request->validate([
            'parent_category'      => 'required',
            'name'                 => 'required|string|max:255',
            'status'               => 'required',
            'show_in_menu'         => 'required',
            'meta_tag'             => 'required|string|max:255',
            'meta_title'           => 'required|string|max:255',
            'meta_description'     => 'required|string',
            'short_description'    => 'required|string',
            'category_image'       => 'nullable',
            'description'          => 'required|string',
        ]);
        $name    = $validatedData['name'];
        $url_key = strtolower($name);
        $url_key = preg_replace('/[^a-zA-Z0-9-]+/', '-', $url_key); 

        $update = Category::where('id',$id)->update([
            'parent_category'            => $validatedData['parent_category'],
            'name'                       => $validatedData['name'],
            'status'                     => $validatedData['status'],
            'show_in_menu'               => $validatedData['show_in_menu'],
            'url_key'                    => $url_key,
            'meta_tag'                   => $validatedData['meta_tag'],
            'meta_title'                 => $validatedData['meta_title'],
            'meta_description'           => $validatedData['meta_description'],
            'short_description'          => $validatedData['short_description'],
            'description'                => $validatedData['description'],
        ]);
        // category product edit 
        $upd = Category::find($id);
        if ($request->category_image) 
        {
            if ($request->hasFile('category_image') && $request->file('category_image')->isValid()) {
                $upd->clearMediaCollection('category_image');
                $upd->addMediaFromRequest('category_image')->toMediacollection('category_image');
            }
        }
        $upd->products()->sync($request->products??[]);

        if ($update) 
        {
            return redirect()->route('category.index')->with('success','Category edit successfully...');
        }else{
            return back()->with('error', 'Something went wrong:');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('category_delete'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $category = Category::where('id',$id)->delete();
        if ($category) 
        {
            return redirect()->route('category.index')->with('success','Category add successfully...');
        }else{
            return redirect()->route('category.index')->with('error','Something went wrong');
        }

    }
}
