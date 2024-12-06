@extends('admin.layouts.admin-layout')
@section('title','Block Edit')
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
            <form action="{{ route('block.update',$block->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title"class="form-control @error('title') border-danger @enderror" value="{{$block->title}}"{{ old('title') }}placeholder="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="heading">heading</label>
                    <input type="text" id="heading" name="heading"class="form-control @error('heading') border-danger @enderror" value="{{$block->heading}}"{{ old('heading') }}placeholder="heading">
                    @error('heading')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name">Description</label>
                    <div class='box '>
                        <div class='box-header'>
                            <h3 class='box-title'>CK Editor <small>Advanced and full of features</small></h3>
                            <!-- tools box -->
                        </div><!-- /.box-header -->
                        <div class='box-body pad'>
                            <textarea id="editor1" name="description" rows="" cols="50">{!! $block->description !!}{{old('description')}}</textarea>
                         {{-- @error('description')
                            <p class="error">{{$message}}</p>
                        @enderror --}}
                        <span class="error" id="description"></span>
                        </div>
                    </div><!-- /.box -->
                </div>
                <div class="form-group">
                    <label for="ordering">ordering</label>
                    <input type="number" id="ordering" name="ordering" class="form-control @error('ordering') border-danger @enderror" value="{{$block->ordering}}"{{ old('ordering') }}placeholder="ordering">
                    @error('ordering')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                <select class="form-control mb-3" name="status">
                    <option>Select status</option>
                    <option value="1" {{$block->status == 1 ? 'selected' : ''}} >Enable</option>
                    <option value="2" {{$block->status == 2 ? 'selected' : ''}} >Disable</option>
                  </select>
                  </div>
                <div class="form-group">
                    <img src="{{$block->getFirstMediaUrl('banner_image')}}" class="img-thumbnail" style="max-width: 200px;" srcset=""><br>
                    <label for="banner_image">Banner Image</label>
                    <input type="file" id="banner_image" name="banner_image"class="form-control @error('banner_image') border-danger @enderror">
                    @error('banner_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection