@extends('admin.layouts.admin-layout')
@section('title', 'Product Details')
@section('content')

    <div class="container mt-4">
        <h1>Product Details</h1>
        <a href="{{route('product.edit',$product->id)}}" class="btn btn-success text-white font-weight-bold">Edit Product</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{ $product->name }}</td>
                </tr>
                <tr>
                    <th>Is Featured</th>
                    <td>{{ $product->is_featured == 1 ? 'Yes' : 'No' }}</td>
                </tr>
                <tr>
                    <th>Sku</th>
                    <td>{{ $product->sku }}</td>
                </tr>
                <tr>
                    <th>Qty.</th>
                    <td>{{ $product->qty }}</td>
                </tr>
                <tr>
                    <th>Stock Status</th>
                    <td>{{ $product->stock_status == 1 ? 'In Stock' : ($product->stock_status == 2 ? 'Few Lefts' : 'No Stock') }}
                    </td>
                </tr>
                <tr>
                    <th>Weight</th>
                    <td>{{ $product->weight }}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>{{ $product->price }}</td>
                </tr>
                <tr>
                    <th>Special Price</th>
                    <td>{{ $product->special_price }}</td>
                </tr>
                <tr>
                    <th>Special Price From</th>
                    <td>{{ $product->special_price_from }}</td>
                </tr>
                <tr>
                    <th>Special Price From To</th>
                    <td>{{ $product->special_price_to }}</td>
                </tr>
                <tr>
                    <th>Short Description</th>
                    <td>{{ $product->short_description }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{!! $product->description !!}</td>
                </tr>
                <tr>
                    <th>Related Products</th>
                    <td>
                        <div class="d-flex flex-wrap">
                            @foreach ($related_products as $relatedProduct)
                                <div style="margin-bottom: 10px;">

                                    <img src="{{ $relatedProduct->getFirstMediaUrl('thumb_image') }}"
                                        alt="{{ $relatedProduct->product_name }}" width="100" height="100">
                                    <br>
                                    {{ $relatedProduct->name }}
                                </div>
                            @endforeach
                        </div>
                    </td>

                </tr>
                <tr>
                    <th>Categories</th>
                    @php
                        $categories=implode(',',$product->categories()->pluck('name')->toArray());
                    @endphp
                    <td>{{$categories}}</td>
                </tr>

                <tr>
                    <th>Thumbnail Image</th>
                    <td><img src="{{ $product->getFirstMediaUrl('thumb_image') }}" alt="no thumbnail Image"
                            style="width: 150px; height: auto;"></td>
                </tr>
                <tr>
                    <th>Banner Images</th>
                    <td>
                        <div class="d-flex flex-wrap">
                            @foreach ($product->getMedia('banner_image') as $image)
                                <div class="mb-2 me-2" style="width: 150px;">
                                    <img src="{{ $image->getUrl() }}" alt="Banner Image" class="img-fluid"
                                        style="width: 100%; height: auto;">
                                </div>
                            @endforeach
                        </div>
                    </td>
                </tr>

                <tr>
                    <th>Attribute & Attribute Values</th>
                    <td>
                        
                            @foreach ($productDetail->productAttributes->groupBy('attribute_id') as $attributeId => $productAttributeS)
                                @php
                                    $attributeName = $productAttributeS->first()->attribute->name;
                                @endphp
                                <h4>{{ $attributeName }}:</h4>
                               
                                    @foreach ($productAttributeS as $productAttribute)
                                     {{ $productAttribute->attributeValue->name }},
                                       
                                    @endforeach 
                                @endforeach
                          
                    </td>
                </tr>
                

            </tbody>
        </table>
        <a href="{{ route('product.index') }}" class="btn btn-primary">Back to Product List</a>
    </div>

@endsection
