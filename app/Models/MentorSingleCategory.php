<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MentorSingleCategory
 *
 * @property int $id
 * @property int $mentor_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleCategory whereMentorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MentorSingleCategory extends Model
{
    use HasFactory;

    public $table = 'mentor_single_categories';
    protected $guarded = ['_token'];
}
