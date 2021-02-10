<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_password_is_hashed_when_stored()
    {
        $user = $this->getUnpersistedUser();
        $unhashedPassword = $user['password'];

        $this->post(route('auth.register'), $user);

        $persistedUser = User::where('email', $user['email'])->first();

        $hashedPassword = $persistedUser->makeVisible('password')->password;

        $this->assertTrue(Hash::check($unhashedPassword, $hashedPassword));
    }
}
