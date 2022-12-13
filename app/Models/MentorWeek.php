<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MentorWeek
 *
 * @property int $id
 * @property string $date_start
 * @property string $date_end
 * @property int $mentor_id
 * @property int $category_id
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $0
 * @property mixed $1
 * @property-read \App\Models\MentorCategory|null $category
 * @property-read \App\Models\Mentor|null $mentor
 * @method static \Illuminate\Database\Eloquent\Builder|MentorWeek newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorWeek newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorWeek query()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorWeek whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorWeek whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorWeek whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorWeek whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorWeek whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorWeek whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorWeek whereMentorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorWeek whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MentorWeek extends Model
{
    use HasFactory;
    
    protected $casts   = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
    ];
    protected $guarded = ['_token'];
    
    public function category()
    {
        return $this->belongsTo(MentorCategory::class, 'category_id', 'id');
    }
    
    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentor_id', 'id');
    }
}
