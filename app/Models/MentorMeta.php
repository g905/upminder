<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MentorMeta
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MentorMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorMeta query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $mentor_id
 * @property string $property
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MentorMeta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorMeta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorMeta whereMentorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorMeta whereProperty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorMeta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorMeta whereValue($value)
 */
class MentorMeta extends Model
{
    use HasFactory;

    public $table = 'mentor_metas';
    protected $fillable = ['mentor_id', 'property', 'value'];
}
