<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use DatabaseMigrations;
    use InteractsWithExceptionHandling;

    /** @test */
    public function can_create_user_with_valid_data()
    {
        $user = $this->getUnpersistedUser();

        $response = $this->post(route('auth.register'), $user);

        unset($user['password']);
        unset($user['confirm_password']);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', $user);
    }

    /** @test */
    public function cannot_create_user_with_invalid_data()
    {
        // Testing with single attributes
        $this->post(route('auth.register'), [])->assertStatus(422);
        $this->post(route('auth.register'), ['name' => 'Juanito'])->assertStatus(422);
        $this->post(route('auth.register'), ['password' => '123456789'])->assertStatus(422);
        $this->post(route('auth.register'), ['email' => 'john@example.com'])->assertStatus(422);

        // Testing in combination of two attributes
        $this->post(route('auth.register'), [
            'name' => 'John Doe',
            'email' => 'john@doe.com'
        ])->assertStatus(422);

        $this->post(route('auth.register'), [
            'email' => 'john@doe.com',
            'password' => '123456789'
        ])->assertStatus(422);

        // Testing with all attributes but invalid syntax
        $this->post(route('auth.register'), [
            'name' => 'John Doe',
            'password' => '12345',
            'confirm_password' => '123456',
            'email' => 'john@doe.com'
        ])->assertStatus(422);

        $this->post(route('auth.register'), $user = [
            'name' => 'John Doe',
            'password' => '123456',
            'confirm_password' => '123456',
            'email' => 'johndoecom'
        ])->assertStatus(422);
    }

    /** @test */
    public function emails_must_be_unique()
    {
        $secondUser = $this->getUnpersistedUser();
        $secondUser['email'] = $this->user->email;

        $this->post(route('auth.register'), $secondUser)->assertStatus(422);
    }

    /** @test */
    public function successful_creation_returns_user_data()
    {
        $user = $this->getUnpersistedUser();

        $response = $this->post(route('auth.register'), $user);

        $desiredStructure = [
            'userid',
            'name',
            'email'
        ];

        $response->assertStatus(201)->assertJsonStructure($desiredStructure);
    }

    /** @test */
    public function existing_user_can_login()
    {
        $credentials = [
            'email' => $this->user->email,
            'password' => '12345678'
        ];

        $response = $this->post(route('auth.login'), $credentials)->assertStatus(200);

        $desiredStructure = [
            'token'
        ];

        $response->assertStatus(200)->assertJsonStructure($desiredStructure);
    }

    /** @test */
    public function unexistent_user_cannot_login()
    {
        $credentials = [
            'email' => 'unexistent@user.com',
            'password' => '15975328'
        ];

        $this->post(route('auth.login'), $credentials)->assertStatus(401);
    }

    /** @test */
    public function me_route_returns_authenticated_user_details()
    {
        $response = $this->get(route('auth.user-info'), $this->token);

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_update_his_information()
    {
        $newData = [
            'name' => 'CompletelyUniqueName',
            'password' => 'newPassword'
        ];

        $response = $this->put(route('users.update', ['user' => $this->user->userid]), $newData, $this->token);

        $this->user = json_decode($response->getContent());
        $this->assertEquals($newData['name'], $this->user->name);

        $response->assertStatus(200)->assertJsonStructure([
            'userid', 'name', 'email'
        ]);
    }

    /** @test */
    public function user_can_delete_his_account()
    {
        $response = $this->delete(route('users.destroy', ['user' => $this->user->userid]), [], $this->token);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['email' => $this->user->email]);
    }
}
