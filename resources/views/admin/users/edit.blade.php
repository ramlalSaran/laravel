@extends('admin.layouts.admin-layout')
@section('title', 'User Edit')
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">user Edit </h6>
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
            <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') border-danger @enderror" value="{{ $user->name }}"{{ old('name') }} placeholder="Name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') border-danger @enderror" value="{{ $user->email }}"{{ old('email') }} placeholder="email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">phone</label>
                    <input type="tel" id="phone" name="phone" class="form-control @error('phone') border-danger @enderror" placeholder="phone" value="{{$user->phone}}" {{old('phone')}}>
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-check">
                                <input type="radio" id="gender_male" class="form-check-input" name="gender" value="m" {{$user->gender == 'm' ? 'checked' : ''}}>
                                <label class="form-check-label" for="gender_male">Male</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input type="radio" id="gender_female" class="form-check-input" name="gender" value="f" {{$user->gender == 'f' ? 'checked' : ''}}>
                                <label class="form-check-label" for="gender_female">Female</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="is_admin">Is Admin</label>
                    <select class="form-control" id="is_admin" aria-describedby="emailHelp"
                        placeholder="" name="is_admin">
                        <option value="">is Admin</option>
                        <option value="1"{{$user->is_admin == 1 ? 'selected' : ''}}>Yes</option>
                        <option value="0"{{$user->is_admin == 0 ? 'selected' : ''}}>No</option>
                    </select>
                    @error('is_admin')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>




                <div class="form-group">
                    <label for="profile_image">Profile(optional)</label><br>
                    <img src="{{ $user->getFirstMediaUrl('profile_image') }}" alt="profile_image" srcset="" width="100" height="100">
                    <input type="file" id="profile_image" name="profile_image" class="form-control @error('profile_image') border-danger @enderror">
                    @error('profile_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @php
                    $strRoles = $user->roles()->pluck('name')->toArray();
                @endphp
                <div class="form-group">
                    <label for="roles">Roles(optional)</label>
                    <div class="row">
                        @foreach ($roles as $role)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="roles[]" value="{{ $role->name }}" {{ in_array($role->name, $strRoles) ? 'checked' : '' }}>

                                    <label class="form-check-label"  for="role_{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
