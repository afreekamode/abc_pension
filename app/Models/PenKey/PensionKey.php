<?php

namespace App\Models\PenKey;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PensionKey extends Model
{
    use HasFactory;
    protected $table = 'pension_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pen_code',
        'pen_code_id', 
        'user_id', 
        'pen_code_type',
        'status',
        'pen_code_ttl',
        'pen_code_status',
    ];
    
}
