<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'contact_no',
        'dob'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function isPharmacy()
    {
        return $this->role === 'pharmacy';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    // Relationship with Quotations (received)
    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    // Relationship with Quotations (sent by pharmacy)
    public function sentQuotations()
    {
        return $this->hasMany(Quotation::class, 'pharmacy_user_id');
    }
}
