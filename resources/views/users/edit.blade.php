@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h5><a href="{{route('users.index')}}">Users</a> / <a href="{{route('users.show', ['user' => $user->id])}}">{{ $user->username }}</a></h5>
                <div class="card">
                    <div class="card-header">{{ __('Edit') .' '.$user->username}}</div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('users.update', ['user' => $user->id]) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="photo" class="col-md-4 col-form-label text-md-end">{{ __('Avatar') }} </label>
                                <div class="col-md-6">
                                    <input type="file" name="photo" class="form-control-file form-control @error('photo') is-invalid @enderror" id="photo">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="prefixname" class="col-md-4 col-form-label text-md-end">{{ __('Prefix Name') }} </label>
                                <div class="col-md-6">
                                    <select name="prefixname" id="prefixname" class="form-control @error('prefixname') is-invalid @enderror" autofocus>
                                        <option value="">Select</option>
                                        <option value="Mr" {{ $user->prefixname == 'Mr' ? 'selected' : '' }}>Mr</option>
                                        <option value="Mrs" {{ $user->prefixname == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                        <option value="Miss" {{ $user->prefixname == 'Miss' ? 'selected' : '' }}>Miss</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="suffixname" class="col-md-4 col-form-label text-md-end">{{ __('Suffix Name') }} </label>
                                <div class="col-md-6">
                                    <select name="suffixname" id="suffixname" class="form-control @error('suffixname') is-invalid @enderror">
                                        <option value="">Select</option>
                                        <option value="Jr" {{ $user->suffixname == 'Jr' ? 'selected' : '' }}>Jr</option>
                                        <option value="Sr" {{ $user->suffixname == 'Sr' ? 'selected' : '' }}>Sr</option>
                                        <option value="II" {{ $user->suffixname == 'II' ? 'selected' : '' }}>II</option>
                                        <option value="III" {{ $user->suffixname == 'III' ? 'selected' : '' }}>III</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }} <span class="required">*</span></label>
                                <div class="col-md-6">
                                    <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ $user->firstname }}" required autocomplete="firstname">

                                    @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="middlename" class="col-md-4 col-form-label text-md-end">{{ __('Middle Name') }} </label>

                                <div class="col-md-6">
                                    <input id="middlename" type="text" class="form-control @error('middlename') is-invalid @enderror" name="middlename" value="{{ $user->middlename }}" autocomplete="middlename">

                                    @error('middlename')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="lastname" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}<span class="required">*</span> </label>

                                <div class="col-md-6">
                                    <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ $user->lastname }}" required autocomplete="lastname">

                                    @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}<span class="required">*</span> </label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" required autocomplete="username">

                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="type" class="col-md-4 col-form-label text-md-end">{{ __('User Type') }} </label>
                                <div class="col-md-6">
                                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" autofocus>
                                        <option value="">Select</option>
                                        <option value="user" {{ $user->type == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="supervisor" {{ $user->type == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
