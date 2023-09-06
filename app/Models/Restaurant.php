<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Restaurant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'name_katakana',
        'review',
        'numComments',
        'food_picture',
        'map_url',
        'phone_number',
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_restaurant');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('comment', 'review')->withTimestamps();
    }
}
