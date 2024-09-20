<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = ['user_id', 'delivery_address', 'delivery_time', 'note', 'prescription_images'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'prescription_images' => 'array',
    ];
}
