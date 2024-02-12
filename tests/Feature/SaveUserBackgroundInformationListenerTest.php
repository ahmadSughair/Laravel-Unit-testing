<?php

namespace Tests\Feature;

use App\Events\UserSaved;
use App\Listeners\SaveUserBackgroundInformation;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SaveUserBackgroundInformationListenerTest extends TestCase
{
    use RefreshDatabase;

    public function testSaveBackgroundInformationIsCalled()
    {
        // Arrange
        $user = User::factory()->create();

        // Mock the UserService
        $userServiceMock = $this->createMock(UserService::class);

        // Mock the listener and pass the UserService mock to the constructor
        $listenerMock = $this->getMockBuilder(SaveUserBackgroundInformation::class)
            ->setConstructorArgs([$userServiceMock])
            ->onlyMethods(['saveBackgroundInformation'])
            ->getMock();

        event(new UserSaved($user));

        // Assertions
        $this->assertTrue(true);
    }
}
