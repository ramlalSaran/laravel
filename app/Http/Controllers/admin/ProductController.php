<?php

namespace App\Http\Controllers\admin;

use Gate;
use App\Models\Page;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Attributevalue;
use App\Models\ProductAttribute;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('product_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        if ($request->ajax()) {
            $data = Product::select('*');
            // dd($data);
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                return $row->status == 1 ? '<span style="background-color: green; color: white; padding: 2px; border-radius: 5px;">Enable</span>' : '<span style="background-color: red; color: white; padding: 2px; border-radius: 5px;">Disable</span>';
            })
    
            ->addColumn('is_featured', function ($row) {
                return $row->is_featured == 1 ? 'Yes' : 'No';
            })
            ->addColumn('categories', function ($row) {
                return implode(',',$row->categories()->pluck('name')->toArray());
            })
            ->addColumn('stock_status', function ($row) {
                return $row->stock_status == 1 
                    ? 'In Stock' 
                    : ($row->stock_status == 2 ? 'Few Lefts' : 'No Stock');
            })
            ->addColumn('image', function ($row) {
                $banner_image = $row->getFirstMediaUrl('thumb_image');
                return $banner_image 
                    ? "<img src='$banner_image' alt='Banner Image' style='width: 70px; height: 70px;'>" : 'No image';
            })
            ->addColumn('action', function ($row) {
                $viewBtn = '<a class="dropdown-item" href="' . route('product.show', $row->id) . '">
                                <i class="fas fa-eye"></i> View
                            </a>';
                $editBtn = '<a class="dropdown-item" href="' . route('product.edit', $row->id) . '">
                                <i class="fas fa-edit"></i> Edit
                            </a>';
                $deleteBtn = '<form action="'. route('product.destroy', $row->id) .'" method="POST" style="display:inline;">
                                '. csrf_field() .'
                                '. method_field("DELETE") .'
                                <button type="submit" class="dropdown-item" onclick="return confirm(\'Are you sure you want to delete this product?\');">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>';

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

            ->rawColumns(['action', 'image', 'status']) // Add 'status' here
            ->make(true);
        }
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('product_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        $attributes      = Attribute::where('status',1)->get();

        $attributeValues = Attributevalue::where('status',1)->get();

        $related_product = Product::all();

        $categories      = Category::where('status',1)->get();

        return view('admin.products.create',compact('related_product','attributes','attributeValues','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('product_store'),Response::HTTP_FORBIDDEN,'403 Forbidden');       
        $validate = $request->validate 
        ([
            'name'                  => 'required|string|max:255',
            'status'                => 'required',
            'is_featured'           => 'required',
            'sku'                   => 'required|unique:products,sku',
            'qty'                   => 'required|integer|min:1',
            'weight'                => 'required|numeric',
            'price'                 => 'required|numeric|min:0',
            'special_price'         => 'nullable|numeric|min:0',
            'special_price_from'    => 'nullable|date',
            'special_price_to'      => 'nullable|date|after_or_equal:special_price_from',
            'short_description'     => 'nullable|string',
            'description'           => 'nullable|string',
            'related_products'      => 'nullable|max:255',
            'meta_tag'              => 'nullable|string|max:255',
            'meta_title'            => 'nullable|string|max:255',
            'meta_description'      => 'nullable|string',
            'thumb_image'           => 'required|image|max:2048',
            'banner_image.*'        => 'nullable|image|max:2048',
        ]);

        if ($validate['qty'] > 5) {
            $stock = '1 ';

        }
        elseif($validate['qty'] <= 5 or $validate['qty'] > 0){

            $stock = '2';

        }
        else{
            $stock = '0';
        }
        // array to string convertion store in database
        if ($request->related_products) 
        {
            $related_products = implode(',',$request->related_products);
        }else{
            $related_products = '';
        }

        $name     = $validate['name'];
        $url_key  = strtolower($name);
        $url_key  = preg_replace('/[^a-zA-Z0-9-]+/', '-', $url_key);

        $product = Product::create([
            'name'                 => $validate['name'],
            'status'               => $validate['status'],
            'is_featured'          => $validate['is_featured'],
            'sku'                  => $validate['sku'],
            'qty'                  => $validate['qty'],
            'stock_status'         => $stock,
            'weight'               => $validate['weight'],
            'price'                => $validate['price'],
            'special_price'        => $validate['special_price'],
            'special_price_from'   => $validate['special_price_from'],
            'special_price_to'     =>  $validate['special_price_to'],
            'short_description'    =>  $validate['short_description'],
            'description'          =>  $validate['description'],
            'related_product'      =>  $related_products,
            'url_key'              =>  $url_key,
            'meta_tag'             =>  $validate['meta_tag'],
            'meta_title'           =>  $validate['meta_title'],
            'meta_description'     =>  $validate['meta_description'],
        ]);

            //         $attributes = $request->input('value_ids', []);

            // foreach ($attributes as $attributeId => $valueIds) {

            
            //         foreach ($valueIds['value_id'] ?? [] as $valueId) {
            //             ProductAttribute::create([
            //                 'product_id' => $product->id, 
            //                 'attribute_id' => $attributeId,
            //                 'attributevalue_id' => $valueId, 
            //             ]);
                    
            //     }
            // }
        foreach($request->attr_value as $id)
        {
          $attr_value = Attributevalue::where('id',$id)->first();
            ProductAttribute::create([
                'product_id'         => $product->id, 
                'attribute_id'       => $attr_value->attribute_id,
                'attributevalue_id'  => $id, 
            ]);
        }
       
        $product->categories()->sync($request->categories);
       
        
        if ($request->hasFile('banner_image')) 
        {
            foreach ($request->file('banner_image') as $banner_image) 
            {
                if ($banner_image->isValid()) 
                {
                    $product->addMedia($banner_image)->toMediaCollection('banner_image');
                }
            }
        }
        

        if ($request->hasFile('thumb_image') && $request->file('thumb_image')->isValid()) 
        {
            $product->addMediaFromRequest('thumb_image')->toMediaCollection('thumb_image');
        }
        
        
        
        return \redirect()->route('product.index')->with('success','Product are add successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('product_show'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $product          = Product::findOrFail($id);

        $relatedIds       = explode(',', $product->related_product);
        
        $related_products = Product::whereIn('id', $relatedIds)->get();

        $productDetail    = Product::with('productAttributes.attributeValue', 'productAttributes.attribute')->where('id', $id)->first();


        return view('admin.products.show', compact('product', 'related_products','productDetail'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('product_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        $attributes        = Attribute::where('status',1)->get();

        $attributeValues   = Attributevalue::where('status',1)->get();

        $related_products  = Product::all();

        $categories        = Category::where('status',1)->get();

        $product           = Product::where('id',$id)->first();

        return view('admin.products.edit',compact('product','related_products','categories','attributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->related_products);

        abort_if(Gate::denies('product_update'),Response::HTTP_FORBIDDEN,'403 Forbidden');
    
        $validate = $request->validate([
                    'name'                 => 'required|string|max:255',
                    'status'               => 'required',
                    'is_featured'          => 'required',
                    'sku'                  => 'required',
                    'qty'                  => 'required|integer|min:1',
                    'weight'               => 'nullable|numeric',
                    'price'                => 'required|numeric|min:0',
                    'special_price'        => 'nullable|numeric|min:0',
                    'special_price_from'   => 'nullable|date',
                    'special_price_to'     => 'nullable|date|after_or_equal:special_price_from',
                    'short_description'    => 'nullable|string',
                    'description'          => 'nullable|string',
                    'related_products'     => 'nullable|max:255',
                    'meta_tag'             => 'nullable|string|max:255',
                    'meta_title'           => 'nullable|string|max:255',
                    'meta_description'     => 'nullable|string',
                    'thumb_image'          => 'nullable|image|max:2048',
                    'banner_image.*'       => 'nullable|image|max:2048',
        ]);



        // related product save with comma use to implode function
        if ($request->related_products)
        {
            $related_products = implode(',',$request->related_products);
        }
        else{
            $related_products = '';
        }

        // save to stock according to qty 
        if ($validate['qty'] > 5) {
            $stock = '1 ';

        }elseif($validate['qty'] <= 5 or $validate['qty'] > 0){

            $stock = '2';

        }else{
            $stock = '0';
        }

        $name    = $validate['name'];
        $url_key = strtolower($name);
        $url_key = preg_replace('/[^a-zA-Z0-9-]+/', '-', $url_key);
        $updateData = [
            'name'                  => $validate['name'],
            'status'                => $validate['status'],
            'is_featured'           => $validate['is_featured'],
            'sku'                   => $validate['sku'],
            'qty'                   => $validate['qty'],
            'stock_status'          => $stock,
            'weight'                => $validate['weight'],
            'price'                 => $validate['price'],
            'special_price'         => $validate['special_price'],
            'special_price_from'    => $validate['special_price_from'],
            'special_price_to'      => $validate['special_price_to'],
            'short_description'     => $validate['short_description'],
            'description'           => $validate['description'],
            'url_key'               => $url_key,
            'related_product'       => $related_products,
            'meta_tag'              => $validate['meta_tag'],
            'meta_title'            => $validate['meta_title'],
            'meta_description'      => $validate['meta_description'],
        ];

            Product::where('id', $id)->update($updateData);

            $product = Product::find($id);
            // category sync to product
            $product->categories()->sync($request->categories);

        if ($request->hasFile('banner_image')) 
        {
            foreach ($request->file('banner_image') as $banner_image) 
            {
                $product->addMedia($banner_image)->toMediaCollection('banner_image');
            }
        }
             



        if ($request->delete_banner_images) 
        {
            foreach ($request->delete_banner_images as $banner_image) 
            {
                $product->deleteMedia($banner_image);
            }
        }
         
        if ($request->thumb_image) 
        {
            if ($request->hasFile('thumb_image') && $request->file('thumb_image')->isValid()) 
            {
                $product->clearMediaCollection('thumb_image');
                $product->addMediaFromRequest('thumb_image')->toMediacollection('thumb_image');
            }
        }

        if ($request->attr_value) 
        {
            ProductAttribute::where('product_id',$id)->delete();  
        
            foreach ($request->attr_value as  $value) 
            {

                $attr_value = Attributevalue::where('id',$value)->first();
                ProductAttribute::create([
                'product_id'        => $id, 
                'attribute_id'      => $attr_value->attribute_id,
                'attributevalue_id' => $value, 
            ]);

        }
            // dd();
        }
            // $attributes = $request->input('value_ids', []);
            // foreach ($attributes as $attributeId => $valueIds) {
            
            //     // print_r($valueIds);
            //     foreach ($valueIds['value_id']??[] as $valueId) {
            //             // echo $valueId;
                       
            //             ProductAttribute::create([
            //                 'product_id' => $id, 
            //                 'attribute_id' => $attributeId,
            //                 'attributevalue_id' => $valueId, 
            //             ]);
            //         }
            // }
           

            return \redirect()->route('product.index')->with('success','Product update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('product_delete'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        Product::where('id',$id)->delete();
        return \redirect()->route('product.index')->with('success','Product are deleted successfully');
    }
    
}