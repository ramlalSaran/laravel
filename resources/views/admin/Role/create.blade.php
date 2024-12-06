@extends('admin.layouts.admin-layout')
@section('title', 'create Role')

@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Role</h6>
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
            <form id="addMoreForm" action="{{ route('role.store') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" id="role" name="role"
                        class="form-control @error('role') border-danger @enderror" value="{{ old('role') }}"
                        placeholder="Name role">
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="permissions">Permissions</label>
                    <div class="row">
                        @foreach ($permissions as $permission)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="permissions[]"
                                        id="permission_{{ $permission->id }}" value="{{ $permission->name }}"
                                        {{ old('permissions') }}>
                                    <label class="form-check-label"
                                        for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
