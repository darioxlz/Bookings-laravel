<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class Facilitie extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'facid';

    protected $fillable = [
        'name',
        'membercost',
        'guestcost',
        'initialoutlay',
        'monthlymaintenance'
    ];

    public function booking () {
        return $this->hasMany(\App\Models\Facilitie::class, 'facid', 'facid');
    }
}
