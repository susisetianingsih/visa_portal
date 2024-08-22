<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_overview extends Model
{
    use HasFactory;
    // Specify the fields that are mass assignable
    protected $fillable = [
        'user_id',
        'vendor_information',
        'vendor_name',
        'vendor_pic',
        'address',
        'vendor_email_address',
        'data_sensitivty',
    ];
}
