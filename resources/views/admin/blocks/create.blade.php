@extends('admin.layouts.admin-layout')
@section('title', 'Block Create')
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Block</h6>
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
            <form action="{{ route('block.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title"class="form-control @error('title') border-danger @enderror" value="{{ old('title') }}"placeholder="Title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="heading">Heading</label>
                    <input type="text" id="heading" name="heading"class="form-control @error('heading') border-danger @enderror" value="{{ old('heading') }}"placeholder="Heading">
                    @error('heading')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <div class='box'>
                        <div class='box-header'>
                            <h3 class='box-title'>CK Editor <small>Advanced and full of features</small></h3>
                        </div>
                        <div class='box-body pad'>
                            <textarea id="editor1" name="description" rows="10" cols="50"></textarea>
                            <span class="error" id="description"></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="ordering">Ordering</label>
                    <input type="number" id="ordering" name="ordering"class="form-control @error('ordering') border-danger @enderror" value="{{ old('ordering') }}"placeholder="Ordering">
                    @error('ordering')
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
                    <label for="banner_image">Banner Image</label>
                    <input type="file" id="banner_image" name="banner_image"class="form-control @error('banner_image') border-danger @enderror">
                    @error('banner_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
