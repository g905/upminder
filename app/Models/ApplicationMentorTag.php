<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ApplicationMentorTag
 *
 * @property int $id
 * @property int $application_id
 * @property int $mentor_tag_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationMentorTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationMentorTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationMentorTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationMentorTag whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationMentorTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationMentorTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationMentorTag whereMentorTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationMentorTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApplicationMentorTag extends Model
{

}
