<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EatLog extends Model
{
    public function appoint()
    {
        return $this->belongsTo(AppointLog::class,'appoint_id','id');
    }
}
