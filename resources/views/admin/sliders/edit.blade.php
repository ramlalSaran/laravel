@extends('admin.layouts.admin-layout')
@section('title', 'Slider Edit')
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Slider Edit</h6>
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
            <form action="{{ route('slider.update', $slider->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="tilte">Tilte</label>
                    <input type="text" id="tilte" name="title" class="form-control @error('title') border-danger @enderror" value="{{ $slider->title }}"{{ old('title') }} placeholder="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="ordering">ordering</label>
                    <input type="number" id="ordering" name="ordering" class="form-control @error('ordering') border-danger @enderror" value="{{ $slider->ordering }}"{{ old('ordering') }} placeholder="ordering">
                    @error('ordering')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <select class="form-control mb-3" name="status">
                        <option>Select status</option>
                        <option value="1"{{ $slider->status == 1 ? 'selected' : '' }}>Enable</option>
                        <option value="2" {{ $slider->status == 2 ? 'selected' : '' }}>Disable</option>
                    </select>
                </div>
                <div class="form-group">
                    <img src="{{ $slider->getFirstMediaUrl('image', 'default-placeholder.jpg') }}" alt="Slider Image"class="img-thumbnail" style="max-width: 200px;"><br>
                    <label for="image">Image</label>

                    <input type="file" id="image" name="image" class="form-control @error('image') border-danger @enderror">

                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
