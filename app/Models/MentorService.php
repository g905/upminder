<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MentorService
 *
 * @property int $id
 * @property int $type_service
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MentorService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorService query()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorService whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorService whereTypeService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorService whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\MentorServiceFactory factory(...$parameters)
 */
class MentorService extends Model
{
    use HasFactory;
    protected $guarded = ['_token'];
    
    public static $types = [
        1 => 'main',
        2 => 'additional'
    ];
    
    public static function getTypes()
    {
        return self::$types;
    }
}
