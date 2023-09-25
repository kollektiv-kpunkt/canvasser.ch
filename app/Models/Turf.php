<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turf extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'geometry',
        'user_id',
        'campaign_id'
    ];

    protected $casts = [
        'geometry' => 'array'
    ];

    /**
     * Get the user that owns the Turf
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the campaign that the Turf belongs to
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

}
