@extends('admin.layouts.admin-layout')
@section('title','Category Table')
@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Category Table</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">dashboard@</a></li>
                <li class="breadcrumb-item">Table</li>
                <li class="breadcrumb-item active" aria-current="page">Categories</li>
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
                @if (session('error'))
                    <div class="alert alert-denger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Category Data</h6>
                        <a href="{{route('category.create')}}" class="btn btn-success text-white font-weight-bold">Add Category</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush data-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Id</th>
                                    <th>Parent Category</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>category_image</th>
                                    <th>Show In Menu</th>
                                    <th>Meta Tag</th>
                                    <th>Meta Title</th>
                                    <th>Url Key</th>
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
                        ajax: "{{ route('category.index') }}",
                        columns: [{
                                data: 'id',
                                name: 'id'
                            },
                            {
                                data: 'parent_category',
                                name: 'parent_category'
                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'status',
                                name: 'status'
                            },
                            {
                                data: 'category_image',
                                name: 'category_image'
                            },
                            {
                                data: 'show_in_menu',
                                name: 'show_in_menu'
                            },
                            {
                                data: 'meta_tag',
                                name: 'meta_tag'
                            },
                            {
                                data: 'meta_title',
                                name: 'meta_title'
                            },
                            {
                                data: 'url_key',
                                name: 'url_key'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });
                });
            </script>
        </tr>
    </tbody>
@endsection
