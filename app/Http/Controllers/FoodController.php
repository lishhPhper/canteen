<?php

namespace App\Http\Controllers;

use App\Service\FoodService;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function serverFood()
    {
        $result['food_list'] = FoodService::getFoodList();
        $result['is_eat'] = FoodService::getIsEat();
        return $this->success('',$result);
    }
}
