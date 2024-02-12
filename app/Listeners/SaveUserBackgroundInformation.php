<?php

namespace App\Listeners;

use App\Events\UserSaved;
use App\Services\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveUserBackgroundInformation implements ShouldQueue
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function handle(UserSaved $event)
    {
        $this->saveBackgroundInformation($event->user);
    }

    public function saveBackgroundInformation($user)
    {
        $savedUser = $this->userService->saveUserDetails($user);
    }
}
