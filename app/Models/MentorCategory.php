<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\Translation\t;

/**
 * App\Models\MentorCategory
 *
 * @property int                             $id
 * @property int|null                        $parent_id
 * @property string                          $name
 * @property \Illuminate\Support\Carbon      $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MentorCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CategoryTag[] $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|MentorCategory[] $children
 * @property-read int|null $children_count
 * @property-read MentorCategory|null $parent
 */
class MentorCategory extends Model
{
    use HasFactory;
    
    protected $guarded = ['_token'];
    
    public function tags()
    {
        return $this->hasMany(CategoryTag::class, 'category_id','id');
    }
    
    public function children()
    {
        return $this->hasMany($this, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo($this, 'parent_id', 'id');
    }
    
    public static function getMainCategories()
    {
        return self::where('parent_id', null);
    }
}
