<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MentorSingleService
 *
 * @property int                             $id
 * @property int                             $mentor_id
 * @property int                             $currency_id
 * @property string|null                     $service
 * @property string                          $price
 * @property string|null                     $discount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleService query()
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleService whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleService whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleService whereMentorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleService wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleService whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleService whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int                             $service_id
 * @method static \Database\Factories\MentorSingleServiceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|MentorSingleService whereServiceId($value)
 * @property-read \App\Models\Currency|null $currency
 */
class MentorSingleService extends Model
{
    use HasFactory;
    
    public    $table    = 'mentor_single_services';
    protected $fillable = [
        'mentor_id',
        'currency_id',
        'name',
        'service_id',
        'price',
        'discount',
    ];
    
    public function service()
    : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MentorService::class, 'service_id', 'id');
    }
    
    public function currency()
    : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
    
}
