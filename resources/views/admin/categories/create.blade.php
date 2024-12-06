@extends('admin.layouts.admin-layout')
@section('title', 'Category Create')
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Create Category</h6>
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
            <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                {{-- Parent Category --}}
                <div class="form-group">
                    <label for="parent_category">Parent Category</label>
                    <select class="form-control mb-3 @error('parent_category') border-danger @enderror" name="parent_category">
                        <option value="0">Select Parent Category</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    @error('parent_category')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Category Name --}}
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" id="name" name="name"class="form-control @error('name') border-danger @enderror" value="{{ old('name') }}"placeholder="Category Name" >
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control mb-3 @error('status') border-danger @enderror" name="status">
                        <option value="">Select Status</option>
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Enable</option>
                        <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Disable</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Show in Menu --}}
                <div class="form-group">
                    <label for="show_in_menu">Show in Menu</label>
                    <select class="form-control mb-3 @error('show_in_menu') border-danger @enderror" name="show_in_menu">
                        <option value="">Select Option</option>
                        <option value="1" {{ old('show_in_menu') == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="2" {{ old('show_in_menu') == 2 ? 'selected' : '' }}>No</option>
                    </select>
                    @error('show_in_menu')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Meta Tag --}}
                <div class="form-group">
                    <label for="meta_tag">Meta Tag</label>
                    <input type="text" id="meta_tag" name="meta_tag"class="form-control @error('meta_tag') border-danger @enderror" value="{{ old('meta_tag') }}" placeholder="Meta Tag">
                    @error('meta_tag')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- products --}}
                <div class="form-group">
                    <label for="products">Products</label>
                    <select class="form-control mb-3 @error('products') border-danger @enderror"name="products[]" multiple="select">
                        <option value="0">Product</option>
                        @foreach ($products as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    @error('products')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Meta Title --}}
                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" class="form-control @error('meta_title') border-danger @enderror" value="{{ old('meta_title') }}" placeholder="Meta Title">
                    @error('meta_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Meta Description --}}
                <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <textarea id="meta_description" name="meta_description"class="form-control @error('meta_description') border-danger @enderror" placeholder="Meta Description">{{ old('meta_description') }}</textarea>
                    @error('meta_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Short Description --}}
                <div class="form-group">
                    <label for="short_description">Short Description</label>
                    <textarea id="short_description" name="short_description"class="form-control @error('short_description') border-danger @enderror" placeholder="Short Description">{{ old('short_description') }}</textarea>
                    @error('short_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Category image --}}
                <div class="form-group">
                    <label for="category_image">Category image</label>
                    
                    <input type="file"  name="category_image" class="form-control @error('category_image') border-danger @enderror">
                    @error('category_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label for="description">Description</label>
                    <div class='box'>
                        <div class='box-header'>
                            <h3 class='box-title'>CKEditor <small>Advanced and full of features</small></h3>
                        </div>
                        <div class='box-body pad'>
                            <textarea id="editor1" name="description" class="form-control @error('description') border-danger @enderror" rows="10" cols="50">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        {{-- @error('description')
                            <span class="error text-danger " id="description">{{ $message }}</span>
                        @enderror --}}
                </div>
                

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
