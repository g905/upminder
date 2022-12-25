<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MentorSingleExperience
 *
 * @property int $id
 * @property int $mentor_id
 * @property string|null $date_start
 * @property string|null $date_end
 * @property int $date_present
 * @property string|null $company
 * @property string|null $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleExperience newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleExperience newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleExperience query()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleExperience whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleExperience whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleExperience whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleExperience whereDatePresent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleExperience whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleExperience whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleExperience whereMentorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleExperience wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleExperience whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MentorSingleExperience extends Model {

    use HasFactory;

    public $table = 'mentor_single_experiences';
    protected $fillable = ['mentor_id', 'date_start', 'date_end', 'date_present', 'company_id', 'position'];

    public function company() {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

}
