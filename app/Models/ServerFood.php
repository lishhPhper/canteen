<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerFood extends Model
{
    public function food()
    {
        return $this->belongsTo(Food::class, 'id','food_id');
    }
}
