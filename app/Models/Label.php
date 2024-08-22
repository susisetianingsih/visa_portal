<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode',
        'label',
    ];

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    protected static function booted()
    {
        static::deleting(function ($label) {
            $label->assessments()->update(['visibility' => 0]);
        });
    }
}
