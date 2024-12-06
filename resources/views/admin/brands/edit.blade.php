@extends('admin.layouts.admin-layout')
@section('title', 'Coupon Create')
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Create Coupon</h6>
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
            <form action="{{ route('brand.update',$brand->id) }}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf

                {{-- Title --}}
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" class="form-control @error('title') border-danger @enderror" value="{{$brand->title}}" placeholder="Coupon Title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Coupon Code --}}
                <div class="form-group">
                    <label for="brand_image">Brand Image</label>
                    <input type="file" id="brand_image" name="brand_image" class="form-control @error('brand_image') border-danger @enderror" value="{{ old('brand_image') }}" placeholder="Coupon Code">
                    <img src="{{asset('storage/'.$brand->brand_image)}}" alt="No Image" srcset="" style='width: 70px; height: 70px;'>
                    @error('brand_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control mb-3 @error('status') border-danger @enderror" name="status">
                        <option value="">Select Status</option>
                        <option value="1" {{ $brand->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="2" {{ $brand->status == 2 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
