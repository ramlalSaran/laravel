@extends('admin.layouts.admin-layout')
@section('title', 'Product Create')
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Create Product</h6>
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
            <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="categories">Categories</label>
                            <select class="form-control mb-3" name="categories[]" multiple>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"{{ in_array($category->id, old('categories', [])) ? 'selected' :'' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('categories')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') border-danger @enderror" value="{{ old('name') }}" placeholder="Product Name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control mb-3 @error('status') border-danger @enderror" name="status">
                                <option value="">Select status</option>
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Enable</option>
                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Disable</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sku">SKU (Stock)</label>
                            <input type="tetx" id="sku" name="sku" class="form-control @error('sku') border-danger @enderror" value="{{ old('sku') }}" placeholder="SKU Enter">
                            @error('sku')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="qty">Quantity (QTY)</label>
                            <input type="number" id="qty" name="qty" class="form-control @error('qty') border-danger @enderror" value="{{ old('qty') }}" placeholder="Quantity">
                            @error('qty')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="weight">Weight</label>
                            <input type="text" id="weight" name="weight" class="form-control @error('weight') border-danger @enderror" value="{{ old('weight') }}" placeholder="Weight">

                            @error('weight')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" id="price" name="price" class="form-control @error('price') border-danger @enderror" value="{{ old('price') }}" placeholder="Price">

                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="editor1" name="description" rows="10" cols="50">{{ old('description') }}</textarea>
                            <span class="error" id="description"></span>
                        </div>

                        <div class="form-group">
                            <label for="thumb_image">Thumbnail Image</label>
                            <input type="file" id="thumb_image" name="thumb_image" class="form-control @error('thumb_image') border-danger @enderror">
                            @error('thumb_image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="related_products">Related Products (comma-separated IDs)</label>
                            <select class="form-control mb-3 @error('related_products') border-danger @enderror" name="related_products[]" multiple>
                                @foreach ($related_product as $related)
                                    <option value="{{ $related->id }}">{{ $related->name }}</option>
                                @endforeach
                            </select>
                            @error('related_products')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="is_featured">Is Featured</label>
                            <select class="form-control mb-3 @error('is_featured') border-danger @enderror"
                                name="is_featured">
                                <option>Select Featured</option>
                                <option value="1" {{ old('is_featured') == 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('is_featured') == 0 ? 'selected' : '' }}>No</option>
                            </select>
                            @error('is_featured')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="special_price">Special Price</label>
                            <input type="text" id="special_price" name="special_price" class="form-control @error('special_price') border-danger @enderror" value="{{ old('special_price') }}" placeholder="Special Price">
                            @error('special_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="special_price_from">Special Price From</label>
                            <input type="date" id="special_price_from" name="special_price_from" class="form-control @error('special_price_from') border-danger @enderror" value="{{ old('special_price_from') }}">
                            @error('special_price_from')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="special_price_to">Special Price To</label>
                            <input type="date" id="special_price_to" name="special_price_to" class="form-control @error('special_price_to') border-danger @enderror" value="{{ old('special_price_to') }}">
                            @error('special_price_to')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="short_description">Short Description</label>
                            <textarea id="short_description" name="short_description" class="form-control @error('short_description') border-danger @enderror" rows="3" placeholder="Short Description">{{ old('short_description') }}</textarea>
                            @error('short_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="meta_tag">Meta Tag</label>
                            <input type="text" id="meta_tag" name="meta_tag" class="form-control @error('meta_tag') border-danger @enderror" value="{{ old('meta_tag') }}" placeholder="Meta Tag">
                            @error('meta_tag')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title" class="form-control @error('meta_title') border-danger @enderror" value="{{ old('meta_title') }}" placeholder="Meta Title">
                            @error('meta_title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" class="form-control @error('meta_description') border-danger @enderror" rows="4" placeholder="Meta Description">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="banner_image">Banner Images</label>
                            <input type="file" id="banner_image" name="banner_image[]" multiple class="form-control @error('banner_image') border-danger @enderror">
                            @error('banner_image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <h5>Attributes</h5>
                        <div class="form-group">
                            @foreach ($attributes as $attribute)
                                <label>{{ $attribute->name }}</label>
                                @foreach ($attribute->attributeValues as $attributeValue)
                                    <div class="form-check ml-3">
                                        <input type="checkbox" name="attr_value[]" class="form-check-input" value="{{ $attributeValue->id }}"{{ in_array($attributeValue->id, old('attr_value', [])) ? 'checked' : '' }} id="attr_value_{{ $attributeValue->id }}">
                                        <label for="attr_value_{{ $attributeValue->id }}" class="form-check-label">{{ $attributeValue->name }}</label>
                                    </div>
                                @endforeach
                            @endforeach

                        </div>


                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
