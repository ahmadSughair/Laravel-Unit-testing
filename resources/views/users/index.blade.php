@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(Route::currentRouteName() == "users.index")
            <div class="my-4 d-flex justify-content-between">
                <div class="btn btn-primary"><a class="page-link" href="{{route('users.trashed')}}">{{ __('Users Trashed') }}</a></div>

                <div class="btn btn-success"><a class="page-link" href="{{route('users.create')}}">{{ __('Add New User') }}</a></div>
            </div>
        @endif

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Avatar</th>
                <th scope="col">Username</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Suffix</th>
                <th scope="col">Prefix</th>
                <th scope="col">Type</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>
                        <div class="avatar-container">
                            <img class="avatar-img" src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Image">
                        </div>
                    </td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->fullname}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->prefixname}}</td>
                    <td>{{$user->suffixname}}</td>
                    <td>{{$user->type}}</td>
                    <td>
                        @if(Route::currentRouteName() == "users.index")
                            <div class="d-flex gap-2">
                                <a type="button" class="btn btn-primary" href="{{route('users.show', ['user' => $user->id])}}">Show</a>
                                <a type="button" class="btn btn-secondary" href="{{route('users.edit', ['user' => $user->id])}}">Update</a>
                                {{--                        <a type="button" class="btn btn-danger" href="{{route('users.destroy', ['user' => $user->id])}}">delete</a>--}}

                                <form method="POST" action="{{route('users.destroy', ['user' => $user->id])}}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <div class="form-group">
                                        <input type="submit" class="btn btn-danger delete-user" value="Delete">
                                    </div>
                                </form>
                            </div>
                        @elseif(Route::currentRouteName() == "users.trashed")
                            <div class="d-flex gap-2">
                                <form method="POST" action="{{route('users.restore', ['user' => $user->id])}}">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}

                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success delete-user" value="Restore">
                                    </div>
                                </form>
                                <form method="POST" action="{{route('users.delete', ['user' => $user->id])}}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <div class="form-group">
                                        <input type="submit" class="btn btn-danger delete-user" value="Delete">
                                    </div>
                                </form>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="my-5">
            {{ $users->links() }}
        </div>
    </div>
@endsection
