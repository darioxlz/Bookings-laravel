<?php

use App\Models\Facilitie;
use App\Models\Member;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Tests\TestCase;
use App\Models\Booking;

class BookingsTest extends TestCase
{
    use DatabaseMigrations;
    use InteractsWithExceptionHandling;

    /** @test */
    public function can_create_booking_with_valid_data()
    {
        Facilitie::factory()->create();
        Member::factory()->create();

        $booking = Booking::factory()->make()->toArray();

        $response = $this->post(route('bookings.store'), $booking, $this->token);

        $response->assertStatus(201);
        $this->assertDatabaseHas('bookings', $booking);
        $response->assertJsonStructure([
            'facid',
            'memid',
            'starttime',
            'slots',
            'bookid'
        ]);
    }

    /** @test */
    public function cannot_create_booking_with_invalid_data()
    {
        // Testing with single attributes
        $this->post(route('bookings.store'), [], $this->token)->assertStatus(422);
        $this->post(route('bookings.store'), ['starttime' => 'Juanito'], $this->token)->assertStatus(422);
        $this->post(route('bookings.store'), ['slots' => 'Galarga'], $this->token)->assertStatus(422);
        $this->post(route('bookings.store'), ['facid' => 'xxxxx'], $this->token)->assertStatus(422);

        // Testing in combination of two attributes
        $this->post(route('bookings.store'), [
            'firstname' => 'John',
            'surname' => 'Doe'
        ], $this->token)->assertStatus(422);

        $this->post(route('bookings.store'), [
            'starttime' => 'micasaaaa',
            'slots' => '123456789'
        ], $this->token)->assertStatus(422);

        // Testing with all attributes but invalid syntax
        $this->post(route('bookings.store'), [
            'facid' => 'John',
            'memdid' => 11,
            'starttime' => 99,
            'slots' => 9999
        ], $this->token)->assertStatus(422);
    }

    /** @test */
    public function facid_must_exists()
    {
        Member::factory()->create();
        Facilitie::factory()->create();

        $booking = Booking::factory()->make(['facid' => 999999])->toArray();

        $this->post(route('bookings.store'), $booking, $this->token)->assertStatus(422);
    }

    /** @test */
    public function memid_must_exists()
    {
        Member::factory()->create();
        Facilitie::factory()->create();

        $booking = Booking::factory()->make(['memid' => 999999])->toArray();

        $this->post(route('bookings.store'), $booking, $this->token)->assertStatus(422);
    }

    /** @test */
    public function can_show_booking_by_id()
    {
        Member::factory()->create();
        Facilitie::factory()->create();

        $booking = Booking::factory()->create()->toArray();

        $response = $this->put(route('bookings.show', ['booking' => $booking['bookid']]), [], $this->token);

        $response->assertStatus(200)->assertJsonStructure([
            'facid',
            'memid',
            'starttime',
            'slots',
            'bookid'
        ]);
    }

    /** @test */
    public function can_not_show_booking_by_wrong_id()
    {
        Member::factory()->create();
        Facilitie::factory()->create();

        Booking::factory()->create()->toArray();

        $response = $this->put(route('bookings.show', ['booking' => 99999]), [], $this->token);

        $response->assertStatus(404);
    }

    /** @test */
    public function booking_can_update_his_information()
    {
        Member::factory()->create();
        Facilitie::factory()->create();

        $booking = Booking::factory()->create()->toArray();

        $newData = [
            'slots' => 15,
            'starttime' => '2021-02-13 13:00:00'
        ];

        $response = $this->put(route('bookings.update', ['booking' => $booking['memid']]), $newData, $this->token);

        $bookingUpdated = json_decode($response->getContent());
        $this->assertEquals($newData['slots'], $bookingUpdated->slots);
        $this->assertEquals($newData['starttime'], $bookingUpdated->starttime);

        $response->assertStatus(200)->assertJsonStructure([
            'slots', 'starttime'
        ]);
    }

    /** @test */
    public function booking_can_delete_his_account()
    {
        Member::factory()->create();
        Facilitie::factory()->create();

        $booking = Booking::factory()->create()->toArray();

        $this->assertDatabaseHas('bookings', ['bookid' => $booking['bookid']]);

        $response = $this->delete(route('bookings.destroy', ['booking' => $booking['bookid']]), [], $this->token);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('bookings', ['bookid' => $booking['bookid']]);
    }
}
