@extends('admin.layouts.admin-layout')
@section('title', 'Product Edit')
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit Product</h6>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ session('error') }}
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                {{-- categories --}}
                @php
                    $productCt=$product->categories()->get();
                    $PrCtg=$productCt->pluck('id')->toArray();
                @endphp

                <div class="form-group">
                    <label for="categories">Categories</label>
                    <select class="form-control mb-3" name="categories[]" multiple="select">
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}"{{in_array($category->id , $PrCtg) ? 'selected' : ''}}>{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Product Name -->
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') border-danger @enderror" value="{{ $product->name }}" placeholder="Product Name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control mb-3" name="status">
                        <option>Select status</option>
                        <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Enable</option>
                        <option value="2" {{ $product->status == 2 ? 'selected' : '' }}>Disable</option>
                    </select>
                </div>

                {{-- Is Featured --}}
                <div class="form-group">
                    <label for="is_featured">Is Featured</label>
                    <select class="form-control mb-3" name="is_featured">
                        <option>Select Featured</option>
                        <option value="1" {{ $product->is_featured == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ $product->is_featured == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <!-- SKU -->
                <div class="form-group">
                    <label for="sku">SKU(Stock)</label>
                    <input type="text" id="sku" name="sku" class="form-control @error('sku') border-danger @enderror" value="{{ $product->sku }}" placeholder="SKU Enter">
                    @error('sku')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Quantity -->
                <div class="form-group">
                    <label for="qty">Quantity(QTY)</label>
                    <input type="number" id="qty" name="qty" class="form-control @error('qty') border-danger @enderror" value="{{ $product->qty }}" placeholder="Quantity">
                    @error('qty')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Stock Status -->
                {{-- <div class="form-group">
                    <label for="stock_status">Stock Status</label>
                    <select class="form-control mb-3" name="stock_status">
                        <option>Select stock status</option>
                        <option value="1" {{ $product->stock_status == 1 ? 'selected' : '' }}>In Stock</option>
                        <option value="2" {{ $product->stock_status == 2 ? 'selected' : '' }}>Few Lefts</option>
                        <option value="0" {{ $product->stock_status == 0 ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div> --}}

                <!-- Weight -->
                <div class="form-group">
                    <label for="weight">Weight</label>
                    <input type="text" id="weight" name="weight" class="form-control @error('weight') border-danger @enderror" value="{{ $product->weight }}"  placeholder="Weight">
                    @error('weight')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Price -->
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" id="price" name="price" class="form-control @error('price') border-danger @enderror" value="{{ $product->price }}" placeholder="Price">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Special Price -->
                <div class="form-group">
                    <label for="special_price">Special Price</label>
                    <input type="text" id="special_price" name="special_price" class="form-control @error('special_price') border-danger @enderror" value="{{ $product->special_price }}" placeholder="Special Price">
                    @error('special_price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Special Price From -->
                <div class="form-group">
                    <label for="special_price_from">Special Price From</label>
                    <input type="date" id="special_price_from" name="special_price_from"  class="form-control @error('special_price_from') border-danger @enderror" value="{{ $product->special_price_from }}">
                    @error('special_price_from')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Special Price To -->
                <div class="form-group">
                    <label for="special_price_to">Special Price To</label>
                    <input type="date" id="special_price_to" name="special_price_to" class="form-control @error('special_price_to') border-danger @enderror" value="{{ $product->special_price_to }}">
                    @error('special_price_to')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Short Description -->
                <div class="form-group">
                    <label for="short_description">Short Description</label>
                    <textarea id="short_description" name="short_description" class="form-control @error('short_description') border-danger @enderror" rows="3" placeholder="Short Description">{{ $product->short_description }}</textarea>
                    @error('short_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <div class='box'>
                        <div class='box-header'>
                            <h3 class='box-title'>CK Editor <small>Advanced and full of features</small></h3>
                        </div>
                        <div class='box-body pad'>
                            <textarea id="editor1" name="description" rows="10" cols="50">{!! $product->description !!}</textarea>
                            <span class="error" id="description"></span>
                        </div>
                    </div>
                </div>

              
                <!-- Related Products -->
                @php
                    $related=explode(',',$product->related_product);
                    @endphp
                    {{-- @dd($related) --}}
                <div class="form-group">
                    <label for="related_products">Related Products</label>
                    <select class="form-control mb-3" name="related_products[]" id="related_products" multiple="select">
                        @foreach ($related_products as $related_product)
                        <option value="{{$related_product->id}}" {{in_array($related_product->id , $related) ? 'selected' : ''}}> {{$related_product->name}} </option>  
                        @endforeach
                    </select>
                    @error('related_products')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Meta Tag -->
                <div class="form-group">
                    <label for="meta_tag">Meta Tag</label>
                    <input type="text" id="meta_tag" name="meta_tag" class="form-control @error('meta_tag') border-danger @enderror" value="{{ $product->meta_tag }}" placeholder="Meta Tag">
                    @error('meta_tag')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Meta Title -->
                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" class="form-control @error('meta_title') border-danger @enderror" value="{{ $product->meta_title }}" placeholder="Meta Title">
                    @error('meta_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Meta Description -->
                <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <textarea id="meta_description" name="meta_description"  class="form-control @error('meta_description') border-danger @enderror" rows="3" placeholder="Meta Description">{{ $product->meta_description }}</textarea>
                    @error('meta_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Thumbnail Image -->
                <div class="form-group">
                    <img src="{{$product->getFirstMediaUrl('thumb_image')}}" alt="" srcset="" class="img-thumbnail" style="width: 100px; height: auto;">
                    <label for="thumb_image">Thumbnail Image</label>
                    <input type="file" id="thumb_image" name="thumb_image"  class="form-control @error('thumb_image') border-danger @enderror">
                    @error('thumb_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Banner Images -->
                <div class="form-group">
                    <h4>Delete</h4>
                    @if (!empty($product->getMedia('banner_image')))
                    <div class="d-flex flex-wrap">
                        @foreach ($product->getMedia('banner_image') as $image)
                            <div class="position-relative me-2 mb-2">
                                <input type="checkbox" id="deleteImage{{ $image->id }}" name="delete_banner_images[]" value="{{ $image->id }}" class="position-absolute top-0 start-0 m-1 z-index-10">
                                <label for="deleteImage{{ $image->id }}">
                                    <img src="{{ $image->getUrl() }}" alt="Banner Image" class="img-thumbnail" style="width: 100px; height: auto;">
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @endif
                    <label for="banner_image">Banner Images</label>
                    <input type="file" id="banner_image" name="banner_image[]"  class="form-control @error('banner_image') border-danger @enderror" multiple>
                    @error('banner_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h5>Attributes</h5>
                        <div class="form-group">
                            @php
                            $checkedValueIds = $product->productAttributes->pluck('attributevalue_id')->toArray();
                           
                        @endphp
                        
                        @foreach ($attributes as $attribute)
                            <label>{{ $attribute->name }}</label>
                            @foreach ($attribute->attributeValues as $attributeValue)
                                <div class="form-check ml-3">
                                    <input type="checkbox" name="attr_value[]" class="form-check-input" value="{{ $attributeValue->id }}" {{ in_array($attributeValue->id , $checkedValueIds) ? 'checked' : '' }} id="attr_value_{{ $attributeValue->id }}">
                                    <label for="attr_value_{{ $attributeValue->id }}" class="form-check-label">{{ $attributeValue->name }}</label>
                                </div>
                            @endforeach
                        @endforeach
                        
                        </div>                        
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>

             
            </form>
        </div>
    </div>
    @endsection 