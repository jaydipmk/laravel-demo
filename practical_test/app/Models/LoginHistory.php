<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    use HasFactory;

    protected   $table = 'login_history';
    protected $fillable = [
        'user_id',
        'created_at',
        'updated_at',
    ];

//    protected $timestamp = false;
//
//    protected $hidden = [
//        'updated_at','created_at'
//    ];

}
