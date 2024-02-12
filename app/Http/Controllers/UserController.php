<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 10;

        // Get paginated list of users
        $users = $this->userService->list($perPage);


        return view('users.index', compact('users'));
    }

    /**
     * Display a listing of the resource.
     */
    public function trashed($perPage = 10)
    {
        $users = $this->userService->listTrashed($perPage);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = $this->userService->store($request->all());

        if ($user) {
            return redirect()->route('users.index')->with('success', 'User has been added successfully.');
        }

        return redirect()->route('users.index')->with('error', 'User not added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user = $this->userService->update($user, $request->all());

        if($user){
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        }

        return redirect()->route('users.index')->with('error', 'User not updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->userService->destroy($user);
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function delete($user)
    {
        $user = $this->userService->delete($user);

        if ($user) {
            return redirect()->route('users.index')->with('success', 'User deleted permanently successfully.');
        } else {
            return redirect()->route('users.index')->with('error', 'User not found or not soft-deleted.');
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($user)
    {
        $user = $this->userService->restore($user);

        if ($user) {
            return redirect()->route('users.index')->with('success', 'User restored successfully.');
        } else {
            return redirect()->route('users.index')->with('error', 'User not found or not soft-deleted.');
        }
    }
}
