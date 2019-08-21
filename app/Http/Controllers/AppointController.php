<?php

namespace App\Http\Controllers;

use App\Service\AppointService;
use Illuminate\Http\Request;

class AppointController extends Controller
{
    public function index()
    {
        $reservation_time = AppointService::getReservationInfo();
    }

    public function confirm(Request $request)
    {
        $type = $request->post('type');
        $AppointService = new AppointService();
        $AppointService->setAppiont($type);
    }
}
