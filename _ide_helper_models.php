<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Booking
 *
 * @property int $bookid
 * @property int|null $facid
 * @property int|null $memid
 * @property string $starttime
 * @property int $slots
 * @property-read \App\Models\Facilitie|null $facility
 * @property-read \App\Models\Member|null $member
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereBookid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereFacid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereMemid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereSlots($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereStarttime($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\BookingFactory factory(...$parameters)
 */
	class Booking extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Facilitie
 *
 * @property int $facid
 * @property string $name
 * @property float $membercost
 * @property float $guestcost
 * @property int $initialoutlay
 * @property int $monthlymaintenance
 * @property-read \Illuminate\Database\Eloquent\Collection|Facilitie[] $booking
 * @property-read int|null $booking_count
 * @method static \Illuminate\Database\Eloquent\Builder|Facilitie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Facilitie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Facilitie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Facilitie whereFacid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facilitie whereGuestcost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facilitie whereInitialoutlay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facilitie whereMembercost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facilitie whereMonthlymaintenance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facilitie whereName($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\FacilitieFactory factory(...$parameters)
 */
	class Facilitie extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Member
 *
 * @property int $memid
 * @property string $surname
 * @property string $firstname
 * @property string $address
 * @property int $zipcode
 * @property string $telephone
 * @property int|null $recommendedby
 * @property string $joindate
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $booking
 * @property-read int|null $booking_count
 * @method static \Illuminate\Database\Eloquent\Builder|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member query()
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereJoindate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereMemid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereRecommendedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereZipcode($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\MemberFactory factory(...$parameters)
 */
	class Member extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 */
	class User extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

