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
class Mentor extends Model {

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

    public function tags() {
        return $this->belongsToMany(CategoryTag::class, 'mentor_tags', 'mentor_id', 'tag_id');
    }

    public function categories() {
        return $this->belongsToMany(MentorCategory::class, 'mentor_single_categories', 'mentor_id', 'category_id');
    }

    public function services() {
        return $this->hasMany(MentorSingleService::class, 'mentor_id', 'id');
    }

    public static function filter(array $filters) {
        $cat = $filters["cat"];
        $catIds = MentorCategory::where("name", "like", "%" . $cat . "%")->get(["id", "parent_id", "name"]);

        $pc = array_values(array_unique(array_column($catIds->toArray(), "parent_id")));
        $parentCatIds = MentorCategory::whereIn('id', $pc)->get(['id', 'name']);

        $t = [];

        foreach ($parentCatIds as $pcc) {
            $pca["pc"] = $pcc;
            $cs = [];
            foreach ($catIds as $c) {
                if ($pcc["id"] === $c["parent_id"]) {
                    $cs[] = $c;
                }
            }
            $pca["cs"] = $cs;
            $t[] = $pca;
        }

        /* $mentors = \Illuminate\Support\Facades\DB::table('mentors')
          ->join('mentor_single_categories', 'mentors.id', 'mentor_single_categories.mentor_id')
          ->join('mentor_categories', 'mentor_categories.id', 'mentor_single_categories.category_id')
          ->whereIn('mentor_single_categories.category_id', $catIds)->get("mentors.email"); */

        return $t;
    }

    public static function getTagsByCatId($id) {
        return CategoryTag::where(['category_id' => $id])->get(["name", "id"]);
    }

    public static function getByForm($form) {
        $tags = [];
        $cat = null;

        $forYou = $vip = false;

        foreach ($form as $row) {
            if ($row["name"] === "tag") {
                $tags[] = $row["value"];
            }

            if ($row["name"] === "cat") {
                $cat = $row["value"];
            }

            if ($row["name"] === "for-you") {
                $forYou = (bool) $row["value"];
            }

            if ($row["name"] === "vip") {
                $vip = (bool) $row["value"];
            }
        }

        $q = \Illuminate\Support\Facades\DB::table('mentors')
                ->join('mentor_tags', 'mentors.id', 'mentor_tags.mentor_id')
                ->join('category_tags', 'mentor_tags.tag_id', 'category_tags.id')
                ->join('mentor_single_categories', 'mentors.id', 'mentor_single_categories.mentor_id')
                ->join('mentor_categories', 'mentor_single_categories.category_id', 'mentor_categories.id');

        if (count($tags)) {
            $q->whereIn('mentor_tags.tag_id', $tags);
        }

        if ($cat) {
            $q->where('mentor_single_categories.category_id', "=", $cat);
        }

        if ($vip) {
            //$q->where('mentors.vip_status', '=', 1);
        }

        $mentors = $q->distinct()->get("mentors.*");

        return $mentors;
    }

}
