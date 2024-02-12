<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

interface UserServiceInterface
{

    public function rules($user) : array;

    public function list(int $perPage = 10);

    public function store(array $data);

    public function find(int $id):? Model;

    public function update(User $user, array $attributes): bool;

    public function destroy(User $user);

    public function listTrashed();

    public function restore(int $id);

    public function delete(int $id);

    public function hash(string $key);

    public function upload(UploadedFile $file);

    public function validateData(array $data, array $rules);

}
