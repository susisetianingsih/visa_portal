<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Implementation_status extends Model
{
    use HasFactory;

    public function user_visa()
    {
        return $this->hasMany(User_visa::class);
    }
}
