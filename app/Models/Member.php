<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class Member extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'memid';

    protected $fillable = [
        'surname',
        'firstname',
        'address',
        'zipcode',
        'telephone',
        'recommendedby',
        'joindate',
        'createdby'
    ];

    public function booking () {
        return $this->hasMany(\App\Models\Booking::class, 'memid', 'memid');
    }
}
