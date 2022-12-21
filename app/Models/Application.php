<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Application
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ApplicationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $application_type_id
 * @property string $last_name
 * @property string $first_name
 * @property string|null $surname
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $telegram
 * @property string|null $communicate_method
 * @property string|null $purpose_mentoring
 * @property int|null $language_id
 * @property string|null $promo_code
 * @property string|null $city
 * @property string|null $timezone Часовой пояс
 * @property string|null $law_name
 * @property string|null $inn
 * @property int $is_checked
 * @property int $is_done
 * @property string|null $resume
 * @property string|null $resume_link
 * @property int|null $category_id
 * @property int|null $mentor_service_id
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereApplicationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCommunicateMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereIsChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereIsDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereLawName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereMentorServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePromoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePurposeMentoring($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereResume($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereResumeLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereTelegram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereTimezone($value)
 * @property int|null $mentor_id
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereMentorId($value)
 * @property-read \App\Models\ApplicationType|null $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CategoryTag[] $mentor_tags
 * @property-read int|null $mentor_tags_count
 */
class Application extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];
    
    public function type()
    {
        return $this->belongsTo(ApplicationType::class, 'application_type_id', 'id');
    }
    
    public static function boot()
    {
        parent::boot();
        static::updating(function($table) {
            $table->is_checked = true;
        });
    }
    
    public function mentor_tags()
    {
        return $this->belongsToMany(CategoryTag::class, ApplicationMentorTag::class,'application_id', 'mentor_tag_id');
    }
}
