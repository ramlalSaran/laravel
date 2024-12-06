@extends('admin.layouts.admin-layout')
@section('title','page Edit')
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Page</h6>
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
            <form action="{{ route('page.update',$page->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" class="form-control @error('title') border-danger @enderror" value="{{$page->title}}"{{ old('title') }} placeholder="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="heading">heading</label>
                    <input type="text" id="heading" name="heading" class="form-control @error('heading') border-danger @enderror" value="{{$page->heading}}"{{ old('heading') }}placeholder="heading">
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
                            <textarea id="editor1" name="description" rows="" cols="50">{!! $page->description !!} {{old('description')}}</textarea>
                         {{-- @error('description')
                            <p class="error">{{$message}}</p>
                        @enderror --}}
                        <span class="error" id="description"></span>
                        </div>
                    </div><!-- /.box -->
                </div>
                <div class="form-group">
                    <label for="ordering">ordering</label>
                    <input type="number" id="ordering" name="ordering" class="form-control @error('ordering') border-danger @enderror" value="{{$page->ordering}}"{{ old('ordering') }} placeholder="ordering">
                    @error('ordering')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                <select class="form-control mb-3" name="status">
                    <option>Select status</option>
                    <option value="1"{{$page->status == 1 ? 'Selected' : ''}}>Enable</option>
                    <option value="2"{{$page->status == 2 ? 'Selected' : ''}}>Disable</option>
                  </select>
                </div>

                {{-- show_in menu --}}
                <div class="form-group">
                    <label for="show_in_menu">show_in_menu</label>
                    <select class="form-control mb-3" name="show_in_menu">
                        <option value="">Show in Menu</option>
                        <option value="1" {{$page->show_in_menu == 1 ? 'selected' : ''}}>Yes</option>
                        <option value="0" {{$page->show_in_menu == 0 ? 'selected' : ''}}>No</option>
                    </select>
                    @error('show_in_menu')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- show in footer --}}
                <div class="form-group">
                    <label for="show_in_footer">show in footer</label>
                    <select class="form-control mb-3" name="show_in_footer">
                        <option value="">Show In Footer</option>
                        <option value="1" {{$page->show_in_footer == 1 ? 'selected' : ''}}>Yes</option>
                        <option value="0" {{$page->show_in_footer == 0 ? 'selected' : ''}}>No</option>
                    </select>
                    @error('show_in_footer')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- meta tag --}}
                <div class="form-group">
                    <label for="meta_tag">Meta Tag</label>
                    <input type="text" id="meta_tag" name="meta_tag" class="form-control @error('meta_tag') border-danger @enderror" value="{{ $page->meta_tag }}" placeholder="meta_tag">
                    @error('meta_tag')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- meta title --}}
                <div class="form-group">
                    <label for="meta_title">meta_title</label>
                    <input type="text" id="meta_title" name="meta_title" class="form-control @error('meta_title') border-danger @enderror" value="{{ $page->meta_title }}" placeholder="meta_title">
                    @error('meta_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
                
                {{-- meta description --}}
                <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" class="form-control @error('meta_description') border-danger @enderror" rows="3" placeholder="Short Description">{{ $page->meta_description}}</textarea>
                    @error('meta_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">
                    <img src="{{$page->getFirstMediaUrl('banner_image')}}" alt="banner_image" class="img-thumbnail" style="max-width: 200px;" srcset=""><br>
                    <label for="banner_image">Banner Image</label>
                    <input type="file" id="banner_image" name="banner_image" class="form-control @error('banner_image') border-danger @enderror">
                    @error('banner_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
