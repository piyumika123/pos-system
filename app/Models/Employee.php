<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'position_id',
        'position',
        'full_name',
        'email_address',
        'address',
        'user_name',
        'phone_number',
        'gender',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
?>
