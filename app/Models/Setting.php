<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Setting
 *
 * @property int                             $id
 * @property string|null                     $name
 * @property string                          $s_key
 * @property string|null                     $s_value
 * @property string|null                     $default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        's_key',
        's_value',
        'default',
    ];
    
    public static function getValue(string $key, $default = '')
    {
        return self::settingValue($key, $default);
    }
    
    private static function settingValue($key, $default)
    {
        $row = self::where('s_key', $key)->first();
        
        if (null === $row) {
            return $default;
        }
        
        return $row->s_value;
    }
    
    public static function setValue(string $key, string $value = null): string
    {
        $value = $value ?? '';

        $setting = self::updateOrCreate([
            's_key' => $key
        ], [
            's_value' => $value
        ]);
        return $setting ? $setting->s_value : '';
    }
    
}
