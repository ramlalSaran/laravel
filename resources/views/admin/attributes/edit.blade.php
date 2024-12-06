@extends('admin.layouts.admin-layout')
@section('title', 'Attribute Edit')
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit Attribute</h6>
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
            <form action="{{route('attribute.update',$attribute->id)}}" method="post">
                @csrf
                @method('put')
                <!-- Attribute Name -->
                <div class="form-group">
                    <label for="name">Attribute Name</label>
                    <input type="text" id="name" name="name"class="form-control @error('name') border-danger @enderror" value="{{$attribute->name}}"placeholder="Attribute Name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Is Variant -->
                <div class="form-group">
                    <label for="is_variant">Is Variant</label>
                    <select class="form-control mb-3 @error('is_variant') border-danger @enderror" name="is_variant">
                        <option value="">Select Variant</option>
                        <option value="1" {{ $attribute->is_variant == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ $attribute->is_variant == 0 ? 'selected' : '' }}>No</option>
                    </select>
                    @error('is_variant')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                     <!-- Status -->
                     <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control mb-3 @error('status') border-danger @enderror" name="status">
                            <option value="">Select status</option>
                            <option value="1" {{  $attribute->status == 1 ? 'selected' : '' }}>Enable</option>
                            <option value="2" {{ $attribute->status == 2 ? 'selected' : '' }}>Disable</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <hr>
                    <table id="attribute-values-table" class="table">
                        <button type="button" class="btn btn-secondary" id="AddRow">Add Attribute Value</button>
                        <thead>
                            <tr>
                                <th>Attribute Value Name</th>
                                <th>Attribute Value Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Dynamic attribute value rows will be appended here -->
                            @foreach ($attributevalues as $attributevalue)
                            <input type="hidden" name="attribute_value_id[]" value="{{$attributevalue->id}}">
                            <tr>
                                <td><input type="text" name="attribute_value_name[]" placeholder="Attribute Value Name" class="form-control" value="{{$attributevalue->name}}"></td>
                                <td>
                                    <select name="attribute_value_status[]" class="form-control">
                                        <option value="1" {{$attributevalue->status == 1 ? 'selected' : '' }}>Enable</option>
                                        <option value="2" {{$attributevalue->status == 2 ? 'selected' : '' }}>Disable</option>
                                    </select>
                                </td>
                                {{-- <td><button type="button" class="btn btn-danger remove-row">Remove</button></td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                   
    
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    
        @section('scripts')
    
        <script>
            $(document).ready(function() {
                $('#AddRow').click(function() {
                    // Create a new row for attribute values
                    const newRow = `
                        <tr>
                            <td><input type="text" name="new_attribute_value_name[]" placeholder="Attribute Value Name" class="form-control"></td>
                            <td>
                                <select name="new_attribute_value_status[]" class="form-control">
                                    <option value="1">Enable</option>
                                    <option value="2">Disable</option>
                                </select>
                            </td>
                            <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
                        </tr>
                    `;
                    // Append the new row to the table body
                    $('#attribute-values-table tbody').append(newRow);
                });
    
                // Remove row functionality
                $('#attribute-values-table').on('click', '.remove-row', function() {
                    $(this).closest('tr').remove();
                });
            });
        </script>
        @endsection
    @endsection
    