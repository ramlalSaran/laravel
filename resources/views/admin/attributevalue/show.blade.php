@extends('admin.layouts.admin-layout')
@section('title', 'Attribute value Details')
@section('content')

    <div class="container mt-4">
        <h1>Attribute Value Details</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>attribute Name</th>
                    <td>{{$attributevalue->attribute_id}}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{$attributevalue->name}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $attributevalue->status == 1 ? 'Enable' : 'Disable' }}</td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('attributevalue.index') }}" class="btn btn-primary">Attribute Value List</a>
    </div>

@endsection
