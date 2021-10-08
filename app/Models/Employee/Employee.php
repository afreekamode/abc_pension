<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';

    protected $fillable = [
        'user_id', 
        'employer_id',
        'employer_name', 
        'employer_code', 
        'nok_phone',
        'nok_email',
        'nok_lname',
        'nok_fname',
        'nok_phone',
        // 'nok_relationship',
        'state_of_origin',
   ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
