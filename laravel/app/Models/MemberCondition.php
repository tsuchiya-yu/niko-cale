<?php

namespace App\Models;

use App\Enums\ConditionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $calendar_member_id
 * @property string $date
 * @property string $condition
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CalendarMember $calendarMember
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCondition whereCalendarMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCondition whereConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCondition whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCondition whereUpdatedAt($value)
 *
 * @property string $condition
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MemberCondition whereCondition($value)
 *
 * @mixin \Eloquent
 */
class MemberCondition extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'calendar_member_id', 'condition'];

    protected $casts = [
        'condition' => ConditionStatus::class,
    ];

    public function calendarMember(): BelongsTo
    {
        return $this->belongsTo(CalendarMember::class);
    }
}
