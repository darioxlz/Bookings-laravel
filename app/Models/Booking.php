<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class Booking extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'bookid';

    protected $fillable = [
        'facid',
        'memid',
        'starttime',
        'slots',
        'createdby'
    ];

    public function facility() {
        return $this->belongsTo(\App\Models\Facilitie::class, 'facid', 'facid');
    }

    public function member() {
        return $this->belongsTo(\App\Models\Member::class, 'memid', 'memid');
    }

    public static function getReservationsByFacId($id) {
        return self::whereHas('facility', function ($query) use ($id) {
            $query->where('facid', '=', $id);
        })->orderBy('bookid');
    }

    public static function getReservationsByMemId($id) {
        return self::whereHas('member', function ($query) use ($id) {
            $query->where('memid', '=', $id);
        })->orderBy('bookid');
    }
}
