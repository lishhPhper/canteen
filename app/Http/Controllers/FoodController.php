<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Food;

class FoodController extends Controller
{
    use Food;
    public function getFoodList()
    {
        return $this->foodList();
    }
}
