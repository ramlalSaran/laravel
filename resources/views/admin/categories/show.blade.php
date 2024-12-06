@extends('admin.layouts.admin-layout')
@section('title', 'category Details')
@section('content')

    <div class="container mt-4">
        <h1>Category Details</h1>
        <a href="{{route('category.edit',$category->id)}}" class="btn btn-success text-white font-weight-bold">Edit Category</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Parent Category</th>
                    <td>{{$category->parent_category}}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{$category->name}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $category->status == 1 ? 'Enable' : 'Disable' }}</td>

                </tr>
                <tr>
                    <th>Show in Menu</th>
                    <td>{{$category->show_in_menu}}</td>
                </tr>
                <tr>
                    <th>Url Key</th>
                    <td>{{$category->url_key}}</td>
                </tr>
                <tr>
                    <th>Meta Tag</th>
                    <td>{{$category->meta_tag}}</td>
                </tr>
                <tr>
                    <th>Meta Tilte</th>
                    <td>{{$category->meta_title}}</td>
                </tr>
                <tr>
                    <th>Meta description</th>
                    <td>{{$category->meta_description}}</td>
                </tr>
                <tr>
                    <th>Short description</th>
                    <td>{{$category->short_description}}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{!! $category->description !!}</td>
                </tr>
                <tr>
                    <th>Products</th>
                    @php
                        $products=implode(',' , $category->products()->pluck('name')->toArray());
                    @endphp
                    <td><strong>{{ $products }} </strong></td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('category.index') }}" class="btn btn-primary">Category List</a>
    </div>

@endsection
