@extends('admin.layouts.admin-layout')
@section('title', 'coupon Details')
@section('content')

    <div class="container mt-4">
        <h1>Coupon Details</h1>
        <a href="{{route('coupon.edit',$coupon->id)}}" class="btn btn-success text-white font-weight-bold">Edit Coupon</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Title</th>
                    <td>{{$coupon->title}}</td>
                </tr>
                <tr>
                    <th>Coupon Code</th>
                    <td>{{$coupon->coupon_code}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $coupon->status == 1 ? 'Enable' : 'Disable' }}</td>

                </tr>
                <tr>
                    <th>Valid From</th>
                    <td>{{$coupon->valid_from}}</td>
                </tr>
                <tr>
                    <th>Valid To</th>
                    <td>{{$coupon->valid_to}}</td>
                </tr>
                <tr>
                    <th>Discount Amount</th>
                    <td>{{$coupon->discount_amount}}</td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('coupon.index') }}" class="btn btn-primary">Coupon List</a>
    </div>

@endsection
