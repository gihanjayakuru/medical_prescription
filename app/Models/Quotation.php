<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = ['prescription_id', 'pharmacy_user_id', 'items', 'total', 'status'];

    protected $casts = [
        'items' => 'array',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function pharmacy()
    {
        return $this->belongsTo(User::class, 'pharmacy_user_id');
    }
}
