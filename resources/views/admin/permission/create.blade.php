@extends('admin.layouts.admin-layout')
@section('title','permission create')
@section('content')

<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Permission</h6>
    </div>
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        {{session('error')}}
      </div>
    @endif
        
   
    <div class="card-body">
        <form id="addMoreForm" action="{{route('permission.store')}}" method="post">
            @csrf
            <div id="permissionFields">
                <button type="button" id="addMore" class="btn btn-secondary mb-3">Add More</button>
                <div class="form-group">
                    <label for="permission">Permission</label>
                    <input type="text" id="permission" name="permission" class="form-control @error('permission') border-danger @enderror" value="{{ old('permission') }}" placeholder="Name Permission">  
                    @error('permission')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#addMore').click(function() {
            var newField = `
                <div class="form-group d-flex align-items-center">
                    <label for="permission" class="mr-2">Permission Name</label>
                    <input type="text" class="form-control permission" name="new_permissions[]" placeholder="Permission Name">
                    <button type="button" class="btn btn-danger removeField ml-2">Remove</button>
                </div>
            `;
            $('#permissionFields').append(newField);
        });

       
        $(document).on('click', '.removeField', function() {
            $(this).closest('.form-group').remove();
        });
    });
</script>
@endsection
