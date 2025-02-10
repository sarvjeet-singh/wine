<?php

namespace App\Models;

use App\Notifications\CustomerVerifyEmail;
use App\Notifications\CustomerResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\WalletController;

class Customer extends Authenticatable implements MustVerifyEmail
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
        'guest_referral_other',
        'guestrewards_vendor_id',
        'guestrewards_social_media',
        'street_address',
        'suite',
        'city',
        'state',
        'postal_code',
        'country',
        'is_other_country',
        'other_country',
        'other_state',
        'government_proof_front',
        'government_proof_back',
        'medical_physical_concerns',
        'alternate_contact_full_name',
        'alternate_contact_relation',
        'date_of_birth',
        'first_login',
        'password_updated',
        'ip_address',
        'email_verified_at',
        'phone_otp',
        'phone_verified_at',
        'form_guest_registry_filled',
        'terms_accepted_at',
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

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomerVerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomerResetPasswordNotification($token));
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($customer) {
            app(WalletController::class)->assignBonus($customer);
        });
    }
}
