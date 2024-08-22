<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_visa extends Model
{
    use HasFactory;
    // Specify the fields that are mass assignable
    protected $fillable = [
        'user_id',
        'assessment_id',
        'implementation_status_id',
        'answer',
        'evidence',
        'remarks',
        'halodoc_comment',
        'vendor_feedback',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'assessment_id', 'id');
    }

    public function implementation_status()
    {
        return $this->belongsTo(Implementation_status::class, 'implementation_status_id', 'id');
    }
}
