<?php

namespace App\Models;

use App\User;

class WebUser extends User
{
    protected $table = 'users';

    protected $fillable = [
        //... 你原先的字段
        'openid',
    ];
}
