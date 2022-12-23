<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ApplicationType
 *
 * @property int $id
 * @property string $short_code
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationType whereShortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApplicationType extends Model
{
    protected $guarded = ['_token'];
}
