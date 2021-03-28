<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Tests\TestCase;
use App\Models\Facilitie;

class FacilitiesTest extends TestCase
{
    use DatabaseMigrations;
    use InteractsWithExceptionHandling;

    /** @test */
    public function can_create_facility_with_valid_data()
    {
        $facility = Facilitie::factory()->make()->toArray();

        $response = $this->post(route('facilities.store'), $facility, $this->token);

        $response->assertStatus(201);
        $this->assertDatabaseHas('facilities', $facility);
        $response->assertJsonStructure([
            'name',
            'membercost',
            'guestcost',
            'initialoutlay',
            'monthlymaintenance',
            'facid'
        ]);
    }

    /** @test */
    public function cannot_create_facility_with_invalid_data()
    {
        // Testing with single attributes
        $this->post(route('facilities.store'), [], $this->token)->assertStatus(422);
        $this->post(route('facilities.store'), ['name' => 'Jua'], $this->token)->assertStatus(422);
        $this->post(route('facilities.store'), ['membercost' => 'Galarga'], $this->token)->assertStatus(422);
        $this->post(route('facilities.store'), ['initialoutlay' => 'xxxxx'], $this->token)->assertStatus(422);

        // Testing in combination of two attributes
        $this->post(route('facilities.store'), [
            'name' => 'John',
            'membercost' => 'Doe'
        ], $this->token)->assertStatus(422);

        $this->post(route('facilities.store'), [
            'initialoutlay' => 'micasaaaa',
            'monthlymaintenance' => '123456789'
        ], $this->token)->assertStatus(422);

        // Testing with all attributes but invalid syntax
        $this->post(route('facilities.store'), [
            'name' => 'John',
            'membercost' => "aq",
            'guestcost' => "p",
            'initialoutlay' => 99,
            'monthlymaintenance' => "kkkk"
        ], $this->token)->assertStatus(422);
    }

    /** @test */
    public function can_show_facility_by_id()
    {
        $facility = Facilitie::factory()->create()->toArray();

        $response = $this->put(route('facilities.show', ['facility' => $facility['facid']]), [], $this->token);

        $response->assertStatus(200)->assertJsonStructure([
            'name',
            'membercost',
            'guestcost',
            'initialoutlay',
            'monthlymaintenance',
            'facid'
        ]);
    }

    /** @test */
    public function facility_can_update_his_information()
    {
        $facility = Facilitie::factory()->create()->toArray();

        $newData = [
            'name' => 'Deportivo La Guaira',
            'membercost' => 10.10
        ];

        $response = $this->put(route('facilities.update', ['facility' => $facility['facid']]), $newData, $this->token);

        $facilityUpdated = json_decode($response->getContent());

        $this->assertEquals($newData['name'], $facilityUpdated->name);
        $this->assertEquals($newData['membercost'], $facilityUpdated->membercost);

        $response->assertStatus(200)->assertJsonStructure([
            'name', 'membercost'
        ]);
    }

    /** @test */
    public function facility_can_delete_his_account()
    {
        $facility = Facilitie::factory()->create()->toArray();

        $this->assertDatabaseHas('facilities', ['facid' => $facility['facid']]);

        $response = $this->delete(route('facilities.destroy', ['facility' => $facility['facid']]), [], $this->token);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('facilities', ['facid' => $facility['facid']]);
    }
}
