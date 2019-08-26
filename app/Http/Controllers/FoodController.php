<?php

namespace App\Http\Controllers;

use App\Service\FoodService;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function serverFood(Request $request)
    {
        $user_id = $request->user->id;
        $FoodService = new FoodService();
        $result['food_list'] = $FoodService->getFoodList();
        $result['is_eat'] = $FoodService->getIsEat($user_id);
        return $this->success('',$result);
    }

    public function toEat(Request $request)
    {
        $user_id = $request->user->id;
        $FoodService = new FoodService();
        $result = $FoodService->toEatSet($user_id);
        return $this->success($result['msg'],$result['data'],$result['result']);
    }
}
