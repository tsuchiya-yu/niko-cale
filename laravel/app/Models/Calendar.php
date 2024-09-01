<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $team_name
 * @property string|null $memo
 * @property string|null $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CalendarMember> $members
 * @property-read int|null $members_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar query()
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereTeamName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereUrl($value)
 *
 * @mixin \Eloquent
 */
class Calendar extends Model
{
    use HasFactory;

    protected $fillable = ['team_name', 'memo'];

    public function members(): hasMany
    {
        return $this->hasMany(CalendarMember::class);
    }

    /**
     * メンバーの名前を指定された区切り文字で連結して取得する
     */
    public function getMemberNames(string $separator = "\n"): string
    {
        return $this->members->pluck('name')->implode($separator);
    }
}
