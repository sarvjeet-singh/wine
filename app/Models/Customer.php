<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'profile_image',
        'profile_image_verified',
        'password',
        'display_name',
        'gender',
        'age_range',
        'contact_number',
        'emergency_contact_name',
        'emergency_contact_relation',
        'emergency_contact_phone_number',
        'facebook',
        'instagram',
        'youtube',
        'tiktok',
        'twitter',
        'linkedin',
        'remember_token',
        'guestrewards',
        'guestreward_user',
        'guestrewards_vendor_id',
        'guestrewards_social_media',
        'street_address',
        'suite',
        'city',
        'state',
        'postal_code',
        'country',
        'government_proof_front',
        'government_proof_back',
        'medical_physical_concerns',
        'alternate_contact_full_name',
        'alternate_contact_relation',
        'date_of_birth',
        'first_login',
        'password_updated',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'first_login' => 'boolean',
        'password_updated' => 'boolean',
    ];

    /**
     * Example relationship (if needed).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rewards()
    {
        return $this->hasMany(Reward::class, 'customer_id');
    }
}