<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MentorTag
 *
 * @property int $id
 * @property int $tag_id
 * @property int $mentor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MentorTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorTag whereMentorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorTag whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MentorTag extends Model
{
    use HasFactory;

    protected $guarded = ['_token'];
    
    
}
