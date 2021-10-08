<?php

namespace App\Models\PenRey;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenRemitance extends Model
{
    use HasFactory;
    
    protected $table = 'rsa_remitance';
    protected $guarded = [];
    protected $fillable = [
        'user_id',
        'amount_credited',
        'employer_name',
        'employer_code',
        'employee_code',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
