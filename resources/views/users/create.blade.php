@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h5><a href="{{route('users.index')}}">Users</a> / create</h5>
                <div class="card">
                    <div class="card-header">{{ __('Create new user')}}</div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('users.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="photo" class="col-md-4 col-form-label text-md-end">{{ __('Avatar') }} </label>
                                <div class="col-md-6">
                                    <input type="file" name="photo" class="form-control-file form-control @error('photo') is-invalid @enderror" id="photo">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="prefix" class="col-md-4 col-form-label text-md-end">{{ __('Prefix Name') }} </label>
                                <div class="col-md-6">
                                    <select name="prefix" id="prefix" class="form-control @error('prefix') is-invalid @enderror" autofocus>
                                        <option value="">Select</option>
                                        <option value="Mr" {{ old('prefix') == 'Mr' ? 'selected' : '' }}>Mr</option>
                                        <option value="Mrs" {{ old('prefix') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                        <option value="Miss" {{ old('prefix') == 'Miss' ? 'selected' : '' }}>Miss</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="suffixname" class="col-md-4 col-form-label text-md-end">{{ __('Suffix Name') }} </label>
                                <div class="col-md-6">
                                    <select name="suffixname" id="suffixname" class="form-control @error('suffixname') is-invalid @enderror" autofocus>
                                        <option value="">Select</option>
                                        <option value="Jr" {{ old('suffixname') == 'Jr' ? 'selected' : '' }}>Jr</option>
                                        <option value="Sr" {{ old('suffixname') == 'Sr' ? 'selected' : '' }}>Sr</option>
                                        <option value="II" {{ old('suffixname') == 'II' ? 'selected' : '' }}>II</option>
                                        <option value="III" {{ old('suffixname') == 'III' ? 'selected' : '' }}>III</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }} <span class="required">*</span></label>
                                <div class="col-md-6">
                                    <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname">

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
                                    <input id="middlename" type="text" class="form-control @error('middlename') is-invalid @enderror" name="middlename" value="{{ old('middlename') }}" autocomplete="middlename">

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
                                    <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname">

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
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">

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
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="type" class="col-md-4 col-form-label text-md-end">{{ __('User Type') }} </label>
                                <div class="col-md-6">
                                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" autofocus>
                                        <option value="">Select</option>
                                        <option value="user" {{ old('type') == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="supervisor" {{ old('type')  == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
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
