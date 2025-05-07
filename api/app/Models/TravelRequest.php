<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelRequest extends Model
{
    use HasFactory;
    /**
     * Get the user that owns the travel request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
