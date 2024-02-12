<?php

namespace App\Services;

use App\Models\Detail;
use App\Models\User;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService implements UserServiceInterface
{
    /**
     * The model instance.
     *
     * @var App\User
     */
    protected $model;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Constructor to bind model to a repository.
     *
     * @param \App\User                $model
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(User $model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;
    }

    /**
     * Define the validation rules for the model.
     *
     * @param  int $id
     * @return array
     */
    public function rules($user = null): array
    {
        // Define validation rules for user data
        if (!$user) {
            $rules = [
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'username' => 'required|string|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        } else {
            $rules = [
                'firstname' => 'string|max:255',
                'lastname' => 'string|max:255',
                'username' => 'string|unique:users,username,' . $user->id,
                'email' => 'email|unique:users,email,' . $user->id,
                'password' => 'string|min:8',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        }

        return $rules;
    }

    /**
     * Retrieve all resources and paginate.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list(int $perPage= 10)
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Create model resource.
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $attributes)
    {
        // Validate and create a new user
        $validatedData = $this->validateData($attributes, $this->rules());
        $validatedData['password'] = $this->hash($validatedData['password']);

        if (!empty($attributes['photo'])) {
            // Store the new image
            $validatedData['photo'] = $this->upload($attributes['photo']);
        }

        return $this->model->create($validatedData);
    }

    /**
     * Retrieve model resource details.
     * Abort to 404 if not found.
     *
     * @param  integer $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id):? Model
    {
        return User::findOrFail($id);
    }

    /**
     * Update model resource.
     *
     * @param  integer $id
     * @param  array   $attributes
     * @return boolean
     */
    public function update(User $user, array $attributes): bool
    {
        // Update user information
        $validatedData = $this->validateData($attributes, $this->rules($user));

        if (!empty($attributes['photo'])) {
            Storage::delete($user->photo);

            // Store the new image
            $validatedData['photo'] = $this->upload($attributes['photo']);
        }

//        dd($user, $validatedData);
        // Update the user
        return $user->update($validatedData);
    }

    /**
     * Soft delete model resource.
     *
     * @param  integer|array $id
     * @return void
     */
    public function destroy(User $user)
    {
        // Delete a user
        $user->delete();
    }

    /**
     * Include only soft deleted records in the results.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function listTrashed($perPage= 10)
    {
        return $this->model->onlyTrashed()->paginate($perPage);
    }

    /**
     * Restore model resource.
     *
     * @param  integer|array $id
     * @return void
     */
    public function restore(int $id)
    {
        // Restore a trashed user
        $user = $this->model->withTrashed()->findOrFail($id);

        if ($user->trashed()) {
            return $user->restore();
        }
    }

    /**
     * Permanently delete model resource.
     *
     * @param  integer|array $id
     * @return void
     */
    public function delete(int $id)
    {
        $user = User::withTrashed()->find($id);

        if ($user->trashed()) {
            return $user->forceDelete();
        }
    }

    /**
     * Generate random hash key.
     *
     * @param  string $key
     * @return string
     */
    public function hash(string $key): string
    {
        return Hash::make($key);
    }

    /**
     * Upload the given file.
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @return string|null
     */
    public function upload(UploadedFile $file)
    {
        // Upload a file and return the path
        return Storage::putFile('public/user_photos', $file);
    }

    public function validateData(array $data, array $rules)
    {
        $validator = Validator::make($data, $rules);

        $validator->validate();

        return $validator->getData();
    }

    public function saveUserDetails($user)
    {
        $details = $user->details()->createMany([
            [
                'key' => 'Full name',
                'value' => $user->fullname,
                'type' => 'bio'
            ],
            [
                'key' => 'Middle Initial',
                'value' => $user->middleinitial,
                'type' => 'bio'
            ],
            [
                'key' => 'Avatar',
                'value' => asset($user->avatar),
                'type' => 'bio'
            ],
            [
                'key' => 'Gender',
                'value' => $user->gender,
                'type' => 'bio'
            ],
        ]);

        return $details;
    }
}
