<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Tests\TestCase;
use App\Models\Member;

class MembersTest extends TestCase
{
    use DatabaseMigrations;
    use InteractsWithExceptionHandling;

    /** @test */
    public function can_create_member_with_valid_data()
    {
        Member::factory()->create();
        $member = Member::factory()->make(['recommendedby' => 1])->toArray();

        $response = $this->post(route('members.store'), $member, $this->token);

        $response->assertStatus(201);
        $this->assertDatabaseHas('members', $member);
        $response->assertJsonStructure([
            'surname',
            'firstname',
            'address',
            'zipcode',
            'telephone',
            'recommendedby',
            'memid'
        ]);
    }

    /** @test */
    public function cannot_create_member_with_invalid_data()
    {
        // Testing with single attributes
        $this->post(route('members.store'), [], $this->token)->assertStatus(400);
        $this->post(route('members.store'), ['firstname' => 'Juanito'], $this->token)->assertStatus(400);
        $this->post(route('members.store'), ['surname' => 'Galarga'], $this->token)->assertStatus(400);
        $this->post(route('members.store'), ['zipcode' => 'xxxxx'], $this->token)->assertStatus(400);

        // Testing in combination of two attributes
        $this->post(route('members.store'), [
            'firstname' => 'John',
            'surname' => 'Doe'
        ], $this->token)->assertStatus(400);

        $this->post(route('members.store'), [
            'address' => 'micasaaaa',
            'telephone' => '123456789'
        ], $this->token)->assertStatus(400);

        // Testing with all attributes but invalid syntax
        $this->post(route('members.store'), [
            'firstname' => 'John',
            'surname' => 11,
            'zipcode' => 99,
            'recommendedby' => 9999
        ], $this->token)->assertStatus(400);
    }

    /** @test */
    public function recommendedby_must_exists()
    {
        $member = Member::factory()->make(['recommendedby' => 999999])->toArray();

        $this->post(route('members.store'), $member, $this->token)->assertStatus(400);
    }

    /** @test */
    public function can_show_member_by_id()
    {
        $member = Member::factory()->create()->toArray();

        $response = $this->put(route('members.show', ['member' => $member['memid']]), [], $this->token);

        $response->assertStatus(200)->assertJsonStructure([
            'surname',
            'firstname',
            'address',
            'zipcode',
            'telephone',
            'recommendedby',
            'memid'
        ]);
    }

    /** @test */
    public function can_not_show_member_by_wrong_id()
    {
        Member::factory()->create();

        $response = $this->put(route('members.show', ['member' => 99999]), [], $this->token);

        $response->assertStatus(404);
    }

    /** @test */
    public function member_can_update_his_information()
    {
        $member = Member::factory()->create()->toArray();

        $newData = [
            'firstname' => 'Alam',
            'surname' => 'Brito'
        ];

        $response = $this->put(route('members.update', ['member' => $member['memid']]), $newData, $this->token);

        $memberUpdated = json_decode($response->getContent());
        $this->assertEquals($newData['firstname'], $memberUpdated->firstname);
        $this->assertEquals($newData['surname'], $memberUpdated->surname);

        $response->assertStatus(200)->assertJsonStructure([
            'firstname', 'surname'
        ]);
    }

    /** @test */
    public function member_can_delete_his_account()
    {
        $member = Member::factory()->create()->toArray();

        $this->assertDatabaseHas('members', ['memid' => $member['memid']]);

        $response = $this->delete(route('members.destroy', ['member' => $member['memid']]), [], $this->token);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('members', ['memid' => $member['memid']]);
    }
}
