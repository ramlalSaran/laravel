@extends('admin.layouts.admin-layout')
@section('title', 'Coupon Edit')
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit Coupon</h6>
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
            <form action="{{ route('coupon.update',$coupon->id) }}" method="post">
                @csrf
                @method('put')

                {{-- Title --}}
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" class="form-control @error('title') border-danger @enderror" value="{{ $coupon->title }}" placeholder="Coupon Title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Coupon Code --}}
                <div class="form-group">
                    <label for="coupon_code">Coupon Code</label>
                    <input type="text" id="coupon_code" name="coupon_code" class="form-control @error('coupon_code') border-danger @enderror" value="{{  $coupon->coupon_code }}" placeholder="Coupon Code">
                    @error('coupon_code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control mb-3 @error('status') border-danger @enderror" name="status">
                        <option value="">Select Status</option>
                        <option value="1" {{  $coupon->status == 1 ? 'selected' : '' }}>Enable</option>
                        <option value="2" {{  $coupon->status == 2 ? 'selected' : '' }}>Disable</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Valid From --}}
                <div class="form-group">
                    <label for="valid_from">Valid From</label>
                    <input type="date" id="valid_from" name="valid_from" class="form-control @error('valid_from') border-danger @enderror" value="{{  $coupon->valid_from }}">
                    @error('valid_from')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Valid To --}}
                <div class="form-group">
                    <label for="valid_to">Valid To</label>
                    <input type="date" id="valid_to" name="valid_to" class="form-control @error('valid_to') border-danger @enderror" value="{{ $coupon->valid_to }}">
                    @error('valid_to')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Discount Amount --}}
                <div class="form-group">
                    <label for="discount_amount">Discount Amount</label>
                    <input type="number" id="discount_amount" name="discount_amount" class="form-control @error('discount_amount') border-danger @enderror" value="{{ $coupon->discount_amount }}"placeholder="Discount Amount">
                    @error('discount_amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
