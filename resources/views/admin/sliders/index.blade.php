@extends('admin.layouts.admin-layout')
@section('title','Slider Table')
@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Slider Table</h1>
            
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
                <li class="breadcrumb-item">Table</li>
                <li class="breadcrumb-item active" aria-current="page">Sliders Table</li>
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
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Slider Data</h6>
                        <a href="{{route('slider.create')}}" class="btn btn-success text-white font-weight-bold">Add Slider</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush data-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Ordering</th>
                                    <th>Status</th>
                                    <th>Image</th>
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
                ajax: "{{ route('slider.index') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'ordering', name: 'ordering' },
                    { data: 'status', name: 'status' },
                    { data: 'image', name: 'image' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
     </tr>
    </tbody>
@endsection
