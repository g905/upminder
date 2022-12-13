<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TaskType
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaskType extends Model {
	
    use HasFactory;
	
	protected $fillable = ['category_id', 'name'];
	
}
