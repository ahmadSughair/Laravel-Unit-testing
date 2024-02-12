@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>User Details</h1>
        <div class="my-3 d-flex justify-content-between">
            <h5><a href="{{route('users.index')}}">Users</a> / {{ $user->username }}</h5>
            <div class="d-flex gap-1">
                <a class="btn btn-primary" href="{{route('users.edit', ['user' => $user->id])}}">Edit</a>
                <form method="POST" action="{{route('users.destroy', ['user' => $user->id])}}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <div class="form-group">
                        <input type="submit" class="btn btn-danger delete-user" value="Delete">
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-5">
            <div class="mb-3 avatar-container">
                <img class="avatar-img" src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Image">
            </div>
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Prefix:</strong> {{ $user->prefixname }}</p>
            <p><strong>First name:</strong> {{ $user->firstname }}</p>
            <p><strong>Middle name:</strong> {{ $user->middlename }}</p>
            <p><strong>Last name:</strong> {{ $user->lastname }}</p>
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Suffix:</strong> {{ $user->suffixname }}</p>
            <p><strong>Type:</strong> {{ $user->type }}</p>
        </div>
    </div>
@endsection
