<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Mentor
 *
 * @property int                                                                   $id
 * @property string                                                                $last_name
 * @property string                                                                $first_name
 * @property string|null                                                           $surname
 * @property int|null                                                              $country_id
 * @property int|null                                                              $city_id
 * @property string|null                                                           $email
 * @property string|null                                                           $phone
 * @property string|null                                                           $telegram
 * @property string|null                                                           $description
 * @property string|null                                                           $help_text
 * @property string|null                                                           $experience
 * @property int                                                                   $verified
 * @property int                                                                   $vip_status
 * @property \Illuminate\Support\Carbon                                            $created_at
 * @property \Illuminate\Support\Carbon|null                                       $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereHelpText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereTelegram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereVipStatus($value)
 * @mixin \Eloquent
 * @property string|null                                                           $timezone Часовой пояс
 * @property int                                                                   $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereTimezone($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MentorTag[] $tags
 * @property-read int|null                                                         $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MentorCategory[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MentorSingleService[] $services
 * @property-read int|null $services_count
 * @property string|null $avatar
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereAvatar($value)
 */
class Mentor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'avatar',
        'last_name',
        'first_name',
        'surname',
        'country_id',
        'city_id',
        'email',
        'phone',
        'telegram',
        'description',
        'help_text',
        'experience',
        'verified',
        'vip_status',
        'is_active',
    ];
    
    public function tags()
    {
        return $this->belongsToMany(CategoryTag::class, 'mentor_tags', 'mentor_id', 'tag_id');
    }
    
    public function categories()
    {
        return $this->belongsToMany(MentorCategory::class, 'mentor_single_categories', 'mentor_id', 'category_id');
    }
    
    public function services()
    {
        return $this->hasMany(MentorSingleService::class, 'mentor_id', 'id');
    }
    
}
