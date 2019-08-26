<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class EvaluationLog extends Model
{
    public function eat()
    {
        return $this->belongsTo(EatLog::class,'id','evaluation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
