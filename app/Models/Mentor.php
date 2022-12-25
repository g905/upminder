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

    public function lessons() {
        return $this->hasMany(Lesson::class, 'mentor_id', 'id');
    }

    public function getDefaultService() {
        return count($this->services) ? $this->services[0] : false;
    }

    public function getActivePrice() {
        $svc = $this->getDefaultService();
        return $svc ? (int) ($svc->price - ($svc->price / 100 * $svc->discount)) : false;
    }

    public function getDefaultCurrency() {
        return $this->getDefaultService()->currency;
    }

    public function jobs() {
        return $this->hasMany(MentorSingleExperience::class);
    }

    public function languages() {
        return $this->belongsToMany(Language::class, 'mentor_languages');
    }

    public function educations() {
        return $this->hasMany(Education::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class)->where(['active' => 1]);
    }

    public function getLanguagesString() {
        return implode(', ', $this->languages->pluck('name')->toArray());
    }

    public function getLastJob() {
        return MentorSingleExperience::where(['mentor_id' => $this->id])->orderByDesc('id')->first() ?? false;
    }

    public function isLocation() {
        return Country::find($this->id) && City::find($this->id);
    }

    public function getLocationString() {
        $string = Country::find($this->id) ? Country::find($this->id)->name : false;
        $string .= City::find($this->id) ? City::find($this->id)->name : false;
        return $string;
    }

    public function getPrimaryServices() {
        //hasManyThrough лучше
        $q = \Illuminate\Support\Facades\DB::table('mentors')
                ->join('mentor_single_services', 'mentors.id', 'mentor_single_services.mentor_id')
                ->join('mentor_services', 'mentor_services.id', 'mentor_single_services.service_id')
                ->where(['mentor_services.type_service' => 1, "mentors.id" => $this->id]);
        return $q->get("mentor_services.*");
    }

    public function getAdditionalServices() {
        //hasManyThrough лучше
        $q = \Illuminate\Support\Facades\DB::table('mentors')
                ->join('mentor_single_services', 'mentors.id', 'mentor_single_services.mentor_id')
                ->join('mentor_services', 'mentor_services.id', 'mentor_single_services.service_id')
                ->where(['mentor_services.type_service' => 2, "mentors.id" => $this->id]);
        return $q->get("mentor_services.*");
    }

    public static function findCats($str) {
        $catIds = MentorCategory::where("name", "like", "%" . $str . "%")->get(["id", "parent_id", "name"]);
        $parentIds = MentorCategory::whereIn('id', $catIds->pluck('parent_id'))->get(['id', 'name']);

        return (count($catIds) && count($parentIds)) ? ["cats" => $catIds, "parents" => $parentIds] : false;
    }

    public static function findTagsByStr($str) {
        $tags = CategoryTag::where("name", "like", "%" . $str . "%")->get(["id", "category_id", "name"]);
        $parents = MentorCategory::whereIn('id', $tags->pluck('category_id'))->get(["id", "parent_id", "name"]);

        return (count($tags) && count($parents)) ? ["tags" => $tags, "parents" => $parents] : false;
    }

    public static function getTagsByCatId($ids) {
        $tags = CategoryTag::whereIn('category_id', (array) $ids)->get(["name", "id", "category_id"]);
        $parents = MentorCategory::whereIn('id', $tags->pluck('category_id'))->get(["id", "parent_id", "name"]);

        return (count($tags) && count($parents)) ? ["tags" => $tags, "parents" => $parents] : false;
    }

    public static function getByForm($form) {
        $tags = [];
        $cat = null;

        $forYou = $vip = false;

        foreach ($form as $row) {
            if ($row["name"] === "page") {
                $page = $row["value"];
            }
            if ($row["name"] === "tag") {
                $tags[] = $row["value"];
            }

            if ($row["name"] === "cat") {
                $cat = $row["value"];
            }

            if ($row["name"] == "for_you") {
                $forYou = (bool) $row["value"];
            }

            if ($row["name"] == "vip") {
                $vip = (bool) $row["value"];
            }
            if ($row["name"] === "sort") {
                $sort = $row["value"];
            }
        }

        $q = Mentor::where(['is_active' => 1]);

        if ($vip) {
            $q->where(['vip_status' => 1]);
        }

        if (count($tags)) {
            $q->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('tag_id', $tags);
            });
        }

        if ($cat) {
            $q->whereHas('categories', function ($q) use ($cat) {
                $q->where('category_id', $cat);
            });
        }

        if ($forYou) {
            $q->whereHas('services', function ($q) {
                $q->whereHas('service', function ($q) {
                    $q->where(['type_service' => 2]);
                });
            });
        }

        self::mentorsSort($q, $sort);
        //echo "<pre>";
        //die(print_r($page));
        $mentors = $q->paginate(2, ['*'], 'page', $page);

        return $mentors;
    }

    public static function mentorsSort(&$q, $type) {
        switch ($type) {
            case "lessons":
                $q->withCount('lessons')->orderBy('lessons_count', 'desc');
                break;
            case "price_asc":
                $q->select(['mentors.*', 'mentor_single_services.price']);
                $q->join('mentor_single_services', 'mentors.id', '=', 'mentor_single_services.mentor_id');
                $q->orderBy('mentor_single_services.price', 'asc');
                break;
            case "price_desc":
                $q->select(['mentors.*', 'mentor_single_services.price']);
                $q->join('mentor_single_services', 'mentors.id', '=', 'mentor_single_services.mentor_id');
                $q->orderBy('mentor_single_services.price', 'desc');
                break;
            default:
                //$q->inRandomOrder();
                break;
        }

        return $q;
    }

}
