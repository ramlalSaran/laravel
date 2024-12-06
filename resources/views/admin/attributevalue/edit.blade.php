@extends('admin.layouts.admin-layout')
@section('title', 'Attribute value edit')
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit Attribute value</h6>
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
            <form action="{{ route('attributevalue.update',$attributevalue->id) }}" method="post">
                @csrf
                @method('put')

                {{-- attribute id --}}
                <div class="form-group">
                    <label for="attribute_id">Attributes</label>
                    <select class="form-control mb-3 @error('attribute_id') border-danger @enderror" name="attribute_id">
                        <option value="">Select Attributes</option>
                        @foreach ($attributes as $attribute)
                        <option value="{{ $attribute->id }}" {{$attributevalue->attribute_id == $attribute->id ? 'selected' : '' }}>
                            {{ $attribute->name }}
                        </option>
                        @endforeach
                        
                    </select>
                    @error('attribute_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Attributevalue Name -->
                <div class="form-group">
                    <label for="name">Attribute value Name</label>
                    <input type="text" id="name" name="name"class="form-control @error('name') border-danger @enderror" value="{{$attributevalue->name}}"placeholder="Attribute Value Name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control mb-3 @error('status') border-danger @enderror" name="status">
                        <option value="">Select status</option>
                        <option value="1" {{ $attributevalue->status == 1 ? 'selected' : '' }}>Enable</option>
                        <option value="2" {{ $attributevalue->status == 2 ? 'selected' : '' }}>Disable</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
