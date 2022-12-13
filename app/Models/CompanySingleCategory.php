<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CompanySingleCategory
 *
 * @property int $id
 * @property int $company_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CompanySingleCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanySingleCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanySingleCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanySingleCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanySingleCategory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanySingleCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanySingleCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanySingleCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CompanySingleCategory extends Model
{
    use HasFactory;

    public $table = 'company_single_categories';
    protected $fillable = ['company_id', 'category_id'];
}
