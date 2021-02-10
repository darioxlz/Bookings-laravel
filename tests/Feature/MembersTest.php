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
        $member = Member::factory()->make()->toArray();

        $response = $this->post(route('members.store'), $member, $this->token);

        $response->assertStatus(201);
        $this->assertDatabaseHas('members', $member);
        $response->assertJsonStructure([
            'surname',
            'firstname',
            'address',
            'zipcode',
            'telephone',
//            'recommendedby',
            'createdby',
            'memid'
        ]);
    }

    /** @test */
    public function cannot_create_member_with_invalid_data()
    {
        // Testing with single attributes
        $this->post(route('members.store'), [], $this->token)->assertStatus(422);
        $this->post(route('members.store'), ['firstname' => 'Juanito'], $this->token)->assertStatus(422);
        $this->post(route('members.store'), ['surname' => 'Galarga'], $this->token)->assertStatus(422);
        $this->post(route('members.store'), ['zipcode' => 'xxxxx'], $this->token)->assertStatus(422);

        // Testing in combination of two attributes
        $this->post(route('members.store'), [
            'firstname' => 'John',
            'surname' => 'Doe'
        ], $this->token)->assertStatus(422);

        $this->post(route('members.store'), [
            'address' => 'micasaaaa',
            'telephone' => '123456789'
        ], $this->token)->assertStatus(422);

        // Testing with all attributes but invalid syntax
        $this->post(route('members.store'), [
            'firstname' => 'John',
            'surname' => 11,
            'zipcode' => 99,
            'recommendedby' => 9999
        ], $this->token)->assertStatus(422);
    }

    /** @test */
    public function recommendedby_must_exists()
    {
        $member = Member::factory()->make(['recommendedby' => 999999])->toArray();

        $this->post(route('members.store'), $member, $this->token)->assertStatus(422);
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

        $response->assertStatus(200)->assertJsonStructure([
            'firstname', 'surname'
        ]);
    }

    /** @test */
    public function member_can_delete_his_account()
    {
        $member = Member::factory()->create()->toArray();

        $response = $this->delete(route('members.destroy', ['member' => $member['memid']]), [], $this->token);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('members', ['memid' => $member['memid']]);
    }
}
