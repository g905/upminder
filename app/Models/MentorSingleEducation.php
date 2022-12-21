<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MentorSingleEducation
 *
 * @property int $id
 * @property int $mentor_id
 * @property string|null $date_start
 * @property string|null $date_end
 * @property int $date_present
 * @property string|null $school
 * @property string|null $course
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleEducation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleEducation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleEducation query()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleEducation whereCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleEducation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleEducation whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleEducation whereDatePresent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleEducation whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleEducation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleEducation whereMentorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleEducation whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleEducation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MentorSingleEducation extends Model
{
    use HasFactory;
    public $table = 'mentor_single_educations';
    protected $fillable = ['mentor_id', 'date_start', 'date_end', 'date_present', 'school', 'course'];

}
