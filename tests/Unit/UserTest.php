<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function test_can_create_user()
    {
        $data = User::factory()->make(['password' => '12345678'])->toArray();
        $data = array_merge($data, array('password' => '12345678', 'confirm_password' => '12345678'));

        $this->post(route('auth.register'), $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'name',
                'email',
                'userid'
            ]);
    }

    public function test_can_update_user()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Alfonsooo'
        ];

        $response = $this->actingAs($user)->put(route('users.update', $user->userid), $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'userid',
                'name',
                'email'
            ]);
    }
//
//    public function test_can_show_user()
//    {
//
//        $user = factory(User::class)->create();
//
//        $this->get(route('users.show', $user->id))
//            ->assertStatus(200);
//    }
//
//    public function test_can_delete_user()
//    {
//
//        $user = factory(User::class)->create();
//
//        $this->delete(route('users.delete', $user->id))
//            ->assertStatus(204);
//    }
//
//    public function test_can_list_users()
//    {
//        $users = factory(User::class, 2)->create()->map(function ($user) {
//            return $user->only(['id', 'title', 'content']);
//        });
//
//        $this->get(route('users'))
//            ->assertStatus(200)
//            ->assertJson($users->toArray())
//            ->assertJsonStructure([
//                '*' => ['id', 'title', 'content'],
//            ]);
//    }
}
