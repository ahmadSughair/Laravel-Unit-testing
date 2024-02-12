<?php

namespace Tests\Unit\Service;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserServiceTest extends TestCase
{

    use RefreshDatabase;

    /** @var UserService */
    private $userService, $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = app(User::class);
        $this->userService = app(UserService::class);
    }
    public function it_can_return_a_paginated_list_of_users()
    {
        // Arrangements
        User::factory()->count(15)->create();

        // Actions
        $users = $this->userService->list();

        // Assertions
        $this->assertCount(10, $users->items());
        $this->assertEquals(15, $users->total());
    }

    /**
     * @test
     * @return void
     */
    public function it_can_store_a_user_to_database()
    {
        // Arrangements
        $userData = [
            'prefixname' => "Mr",
            'firstname' => "Ahmad",
            'middlename' => "Kuleab",
            'lastname' => "Sughair",
            'username' => "ahmad96",
            'email' => 'john.doe@example.com',
            'password' => 'password123',
        ];

        // Actions
        $user = $this->userService->store($userData);

        // Assertions
        $this->assertDatabaseHas('users', ['email' => 'john.doe@example.com']);
        $this->assertInstanceOf(User::class, $user);

    }

    /**
     * @test
     * @return void
     */
    public function it_can_find_and_return_an_existing_user()
    {
        // Arrangements
        $user = User::factory()->create();

        // Actions
        $foundUser = $this->userService->find($user->id);

        // Assertions
        $this->assertEquals($user->id, $foundUser->id);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_update_an_existing_user()
    {
        // Arrangements
        $user = User::factory()->create();

        // Actions
        $this->userService->update($user, ['firstname' => 'Updated Name']);

        // Assertions
        $this->assertDatabaseHas('users', ['id' => $user->id, 'firstname' => 'Updated Name']);

    }

    /**
     * @test
     * @return void
     */
    public function it_can_soft_delete_an_existing_user()
    {
        // Arrangements
        $user = User::factory()->create();
        // Actions
        $this->userService->destroy($user);

        // Assertions
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_return_a_paginated_list_of_trashed_users()
    {
        // Arrangements
        User::factory()->count(15)->create();
        User::factory()->count(5)->create(['deleted_at' => now()]);

        // Actions
        $trashedUsers = $this->userService->listTrashed();

        // Assertions
        $this->assertCount(5, $trashedUsers->items());
        $this->assertEquals(5, $trashedUsers->total());
    }

    /**
     * @test
     * @return void
     */
    public function it_can_restore_a_soft_deleted_user()
    {
        // Arrangements
        $user = User::factory()->create(['deleted_at' => now()]);

        // Actions
        $this->userService->restore($user->id);

        // Assertions
        $this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_permanently_delete_a_soft_deleted_user()
    {
        // Arrangements
        $user = User::factory()->create(['deleted_at' => now()]);

        // Actions
        $this->userService->delete($user->id);

        // Assertions
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_upload_photo()
    {
        // Arrangements
        $user = User::factory()->create();

        // Actions
        Storage::fake('public');
        $photo = UploadedFile::fake()->image('avatar.jpg');
        $path = $this->userService->upload($photo);

        // Assertions
        $this->assertFileExists(storage_path('app/' . $path));
    }

}
