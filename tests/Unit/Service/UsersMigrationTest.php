<?php

namespace Tests\Unit\Service;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UsersMigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('users', [
            'prefixname',
            'suffixname',
            'firstname',
            'middlename',
            'lastname',
            'email',
            'username',
            'type',
            'email_verified_at',
            'password',
            'photo',
            'remember_token',
            'created_at',
            'updated_at',
            'deleted_at'
        ]));
    }
}
