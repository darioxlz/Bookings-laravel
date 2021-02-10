<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * User to be used when authentication is needed
     *
     */
    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory()->count(3)->create();
        $this->user = json_decode($this->post(route('auth.register'), User::factory()->make(['password' => '12345678', 'confirm_password' => '12345678'])->makeVisible('password')->toArray())->getContent());
        $this->token = json_decode($this->post(route('auth.login'), ['email' => $this->user->email, 'password' => '12345678'])->getContent());

        $this->token = ['Authorization' => "Bearer ".$this->token->token];

        //$this->withoutExceptionHandling(); //To get the actual Exception whenever it occurs instead of Laravel handing the exception.
    }

    /**
     * Returns an array with the unpersisted
     * User Data
     *
     * @return array
     */
    protected function getUnpersistedUser(): array
    {
        return User::factory()->make(['password' => '12345678', 'confirm_password' => '12345678'])->makeVisible('password')->toArray();
    }

    /**
     * Returns a decoded response
     *
     * @return array
     */
    protected function getDecodedResponse(): array
    {
        return json_decode($this->response->getContent(), true);
    }
}
