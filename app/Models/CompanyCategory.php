<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CompanyCategory
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CompanyCategory extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'name'];
}
