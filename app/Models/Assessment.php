<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question',
        'halodoc_expectation',
        'expected_evidence',
        'label_id',
        'visibility',
    ];

    public function label()
    {
        return $this->belongsTo(Label::class, 'label_id', 'id');
    }

    public function user_visa()
    {
        return $this->hasMany(User_visa::class);
    }
}
