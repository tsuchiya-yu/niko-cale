<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $calendar_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Calendar $calendar
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CalendarMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CalendarMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CalendarMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|CalendarMember whereCalendarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CalendarMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CalendarMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CalendarMember whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CalendarMember whereUpdatedAt($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MemberCondition> $conditions
 * @property-read int|null $conditions_count
 *
 * @mixin \Eloquent
 */
class CalendarMember extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }

    public function conditions(): HasMany
    {
        return $this->hasMany(MemberCondition::class);
    }
}
