<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationLog extends Model
{
    public function eat()
    {
        return $this->belongsTo(EatLog::class,'id','evaluation_id');
    }
}
