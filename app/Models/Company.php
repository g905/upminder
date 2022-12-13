<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property string $law_name
 * @property string|null $inn
 * @property int|null $country_id
 * @property int|null $city_id
 * @property string $contact_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $website
 * @property string|null $description
 * @property string|null $logo
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLawName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereWebsite($value)
 * @mixin \Eloquent
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'law_name', 'inn', 'country_id', 'city_id', 'contact_name', 'phone', 'email', 'website', 'description', 'logo'];

}
