@extends('admin.layouts.admin-layout')
@section('title','User Table')
@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">User Table</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
                <li class="breadcrumb-item">Table</li>
                <li class="breadcrumb-item active" aria-current="page">Users Table</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('success') }}
                    </div>
                @endif
                <a href="{{ route('user.create') }}" class="btn mb-3" style="background: rgb(11, 213, 25);color:white ; "><strong>User Add</strong></a>
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">User Data</h6>
                    </div>
                    <div class="table-responsive">
                        
                        <table class="table align-items-center table-flush data-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Is_admin</th>
                                    <th>Image</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                         

                              
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
        <!--Row-->

    </div>
@endsection
@section('scripts')
<tbody>
    <tr>
    <script>
        $(document).ready(function() {  
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user.index') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'gender', name: 'gender' },
                    { data: 'is_admin', name: 'is_admin' },
                    { data: 'image', name: 'image' },
                    { data: 'roles', name: 'roles' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
     </tr>
    </tbody>
@endsection
