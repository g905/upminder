<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Lesson
 *
 * @property int                             $id
 * @property int                             $mentor_id
 * @property string|null                     $description
 * @property string|null                     $lesson_start
 * @property string|null                     $lesson_end
 * @property float                           $price
 * @property string                          $client
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereLessonEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereLessonStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereMentorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Mentor|null    $mentor
 * @property \Illuminate\Support\Carbon|null $date_start
 * @property \Illuminate\Support\Carbon|null $date_end
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereDateStart($value)
 * @method static \Database\Factories\LessonFactory factory(...$parameters)
 */
class Lesson extends Model
{
    use HasFactory;
    
    protected $guarded = ['_token'];
    
    public $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
    ];
    
    
    public function mentor() {
        return $this->belongsTo(Mentor::class, 'mentor_id', 'id');
    }
}
