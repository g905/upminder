<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CategoryTag
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTag query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTag whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTag whereUpdatedAt($value)
 * @property int $is_filter
 * @property-read \App\Models\MentorCategory|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTag whereIsFilter($value)
 */
class CategoryTag extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];
    
    public function category()
    {
        return $this->belongsTo(MentorCategory::class,'category_id', 'id');
    }
}
