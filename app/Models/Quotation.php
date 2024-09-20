<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        'prescription_id',
        'pharmacy_user_id',
        'user_id',
        'items',
        'total',
        'status',
    ];

    // Relationship with Prescription
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    // Relationship with Pharmacy User
    public function pharmacyUser()
    {
        return $this->belongsTo(User::class, 'pharmacy_user_id');
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
