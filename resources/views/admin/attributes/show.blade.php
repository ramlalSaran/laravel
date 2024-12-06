@extends('admin.layouts.admin-layout')
@section('title', 'Attribute Details')
@section('content')

    <div class="container mt-4">
        <h1>Attribute Details</h1>
        <table class="table table-bordered">
            <a href="{{route('attribute.edit',$attribute->id)}}" class="btn btn-success text-white font-weight-bold">Edit Attribute</a>
            
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{$attribute->name}}</td>
                </tr>
                <tr>
                    <th>Is Variant</th>
                    <td>{{$attribute->is_variant == 1 ? 'Yes' : 'No'}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $attribute->status == 1 ? 'Enable' : 'Disable' }}</td>
                </tr>
                <tr>
                    <th>Attribute_value</th>
                    @php
                        $attribute_value=implode(',',$attribute->attributeValues()->pluck('name')->toArray());
                    @endphp
                    <td>{{$attribute_value}}</td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('attribute.index') }}" class="btn btn-primary">Back to Attribute List</a>
    </div>

@endsection
