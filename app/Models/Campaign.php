<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'slug',
        'title',
        'description',
        'region',
        'admins',
    ];

    protected $casts = [
        'admins' => 'array',
    ];

    /**
     * Get all of the turfs for the Campaign
     */
    public function turfs()
    {
        return $this->hasMany(Turf::class);
    }

    /**
     * Get all of the campaigns for the User
     */
    public static function usersCampaigns()
    {
        return Campaign::whereJsonContains('admins', strval(auth()->user()->id))->get();
    }
}
